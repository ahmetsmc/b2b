<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductUnit;
use App\Models\ProductVariant;
use App\Services\Interfaces\ProductInterface;
use App\Traits\HasRepositoryRoof;
use App\Traits\HasUpload;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Decoders\EncodedImageObjectDecoder;
use Intervention\Image\EncodedImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;
use Intervention\Image\Facades\Image;
use Intervention\Image\Interfaces\EncoderInterface;

class ProductRepository implements ProductInterface
{
    use HasRepositoryRoof, HasUpload;

    public Product|null $product = null;

    public function setProduct(Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getAllProducts()
    {
        return Product::paginate($this->perBy);
    }

    public function findById($id)
    {
        return Product::with($this->withEagerLoads)->find($id);
    }

    public function filterAllProducts(array $data = [])
    {
        return Product::when(isset($data['q']), function ($query) use ($data) {
            $query->where('title', 'LIKE', '%' . $data['q'] . '%');
        })->when(isset($data['category_id']), function ($query) use ($data) {
            $query->where('category_id', $data['category_id']);
        })->when(isset($data['categories']) && is_array($data['categories']), function ($query) use ($data) {
            $query->whereIn('category_id', $data['categories']);
        })->when(isset($data['stock']), function ($query) use ($data) {
            $operator = $data['stock'] != 1 ? '<=' : '>=';
            $query->where('stock', $operator, 0);
        })->paginate($this->perBy);
    }

    public function createProduct($data): static
    {
        $this->product = Product::create($data);

        if ($this->product && isset($data['variants'])) {
            $this->createVariants($this->product, $data['variants']);
        }

        return $this;
    }

    public function updateProduct(array $data): static
    {
        if (!$this->product) {
            $this->setError(__('Product Not Found'));
            return $this;
        }

        $this->product->update($data);
        if (isset($data['variants'])) {
            $this->createVariants($this->product, $data['variants']);
        }

        return $this;
    }

    public function createVariants(Product $product, $variants)
    {
        $this->product = $product;

        foreach ($variants as $key => $variant) {
            if (isset($variant['image'])) {
                $dir = 'products/' . $this->product->id . '/variants';
                checkAndCreateFolder($dir);
                $variant['image'] = $this->uploadFile($variant['image'], $dir);
            }

            if (str_starts_with($key, 'new')) {
                $this->product->variants()->create($variant);
            } else {
                $item = $this->product->variants()->where('id', $key)->first();
                if ($item) {
                    $item->update($variant);
                }
            }
        }
    }

    public function deleteProduct(int $id): static
    {
        $product = Product::find($id);

        if (!$product) {
            $this->setError(__('Product Not Found'));
            return $this;
        }

        if (true != false) {
            // TODO: ürün silmek için herhangi bir engel var mı kontrol edilmeli
            // örneğin herhangi bir siparişteyse
            // ilgili görselleri vs temizle
        }

        $product->delete();

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getProductUnits(): Collection
    {
        return ProductUnit::all();
    }

    public function uploadGallery(UploadedFile $file): ?ProductGallery
    {
        if (!$this->product) {
            return null;
        }

        $type = $file->getMimeType();
        $size = $file->getSize();
        $name = $file->getClientOriginalName();
        $ranking = $this->getProductLastGalleryRanking();

        $saveName = str(date('YmdHi') . pathinfo($name, PATHINFO_FILENAME))->slug();

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($file);

        checkAndCreateFolder('products/' . $this->product->id);

        $smallDir = 'storage/products/' . $this->product->id . '/' . $saveName . '-small.jpg';
        $largeDir = 'storage/products/' . $this->product->id . '/' . $saveName . '-large.jpg';

        $image->scale(300, 300)->toJpeg(70)->save($this->normalizePath(public_path($smallDir)));

        $image = $manager->read($file);
        $width = $image->width();
        $height = $image->height();

        if ($width > 1080 || $height > (1080 / ($width / $height))) {
            $image->scale(1080, (1080 / ($width / $height)))->toJpeg(70)->save($this->normalizePath(public_path($largeDir)));
        } else {
            $image->toJpeg(70)->save($this->normalizePath(public_path($largeDir)));
        }

        $gallery = $this->product->galleries()->create([
            'product_id' => $this->product->id,
            'small_path' => str_replace('storage/', '', $smallDir),
            'large_path' => str_replace('storage/', '', $largeDir),
            'is_cover' => $this->product->galleries()->count() < 1 ? 1 : 0,
            'size' => $size,
            'mimetype' => $type,
            'name' => $name,
            'ranking' => $ranking,
        ]);

        return $gallery;
    }

    public function getProductLastGalleryRanking(): int
    {
        if (!$this->product) {
            return 1;
        }

        $lastGallery = ProductGallery::where('product_id', $this->product->id)->orderBy('ranking', 'desc')->first();

        return $lastGallery ? ($lastGallery->ranking + 1) : 1;
    }

    public function setCoverGallery($galleryId): static
    {
        if (!$this->product) {
            $this->setError(trans('Product not found'));
            return $this;
        }

        $gallery = $this->product->galleries()->where('id', $galleryId)->first();

        if (!$gallery) {
            $this->setError(trans('Gallery image not found'));
            return $this;
        }

        foreach ($this->product->galleries()->where('is_cover', 1)->get() as $productGallery) {
            $productGallery->update([
                'is_cover' => 0
            ]);
        }

        $gallery->update([
            'is_cover' => 1
        ]);

        return $this;
    }

    public function deleteGallery($galleryId): static
    {
        if (!$this->product) {
            $this->setError(trans('Product not found'));
            return $this;
        }

        $gallery = $this->product->galleries()->where('id', $galleryId)->first();

        if (!$gallery) {
            $this->setError(trans('Gallery image not found'));
            return $this;
        }

        if ($gallery->isCover()) {
            $this->setError(trans('You cant delete cover gallery'));
            return $this;
        }

        // TODO: fiziksel sil

        $gallery->delete();

        return $this;
    }

    public function updateGalleryRanking($galleries): static
    {
        if (!$this->product) {
            $this->setError(trans('Product not found'));
            return $this;
        }

        $ranking = 0;

        foreach ($galleries as $galleryId) {
            $gallery = $this->product->galleries()->where('id', $galleryId)->first();
            if ($gallery) {
                $ranking++;
                $gallery->update([
                    'ranking' => $ranking
                ]);
            }
        }

        return $this;
    }

    public function updateStatus($is_active): static
    {
        if (!$this->product) {
            $this->setError(trans('Product not found'));
            return $this;
        }

        $is_active = filter_var($is_active, FILTER_VALIDATE_BOOLEAN);

        $this->product->update([
            'status' => $is_active ? 'ACTIVE' : 'PASSIVE'
        ]);

        return $this;
    }

    public function getAllVariants(): \Illuminate\Pagination\LengthAwarePaginator|Collection
    {
        if (!$this->product) {
            return new Collection();
        }

        return ProductVariant::with($this->withEagerLoads)->where('product_id', $this->product->id)->paginate($this->perBy);
    }

    public function findVariantById(int $variantId): ProductVariant|null
    {
        return ProductVariant::with($this->withEagerLoads)->where('id', $variantId)->first();
    }

    public function deleteProductVariant(int $productId, int $variantId)
    {
        $product = Product::with('variants')->where('id', $productId)
            ->whereHas('variants', function ($query) use ($variantId) {
                return $query->where('id', $variantId);
            })->first();

        if (!$product) {
            $this->setError(trans('Product variant not found', [], $this->locale));
        }

        $variant = $product->variants()->where('id', $variantId)->first();

        if ($variant) {
            // todo: ilişkiler (sepet vs) kontrol et
            $variant->delete();
        }

        return $this;
    }

    public function bulkUpdate(array $productIds, array $actions)
    {
        $products = Product::whereIn('id', $productIds)->get();

        if (count($productIds) != $products->count()) {
            $this->setError('Seçilen ürünlerde geçersiz kayıtlar var.');
            return $this;
        }

        $data = $this->prepareBulkUpdateData($products, $actions);

        $this->handleBulkDelete($data);

        return $this;
    }

    public function prepareBulkUpdateData($products, $actions): array
    {
        $updateData = [];

        foreach ($actions as $field => $action) {
            if (isset($action['status']) && !is_null($action['status'])) {
                foreach ($products as $product) {
                    if (isset($action['value']) && !is_null($action['value'])) {
                        $value = match ($action['status']) {
                            'update' => $action['value'],
                            'add' => $product->$field + (int)$action['value'],
                            'subtract' => $product->$field - (int)$action['value'],
                        };

                        $updateData[$product->id][$field] = $value;
                    }
                }
            }
        }

        return $updateData;
    }

    public function handleBulkDelete(array $data)
    {
        DB::beginTransaction();

        try {
            foreach ($data as $productId => $action) {
                $product = Product::find($productId);
                $product->update($action);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('productRepository@handleBulkDelete: ' . $exception->getMessage());
            $this->setError('Bilinmeyen bir sorun oluştu, lütfen tekrar deneyin');
        }
    }
}
