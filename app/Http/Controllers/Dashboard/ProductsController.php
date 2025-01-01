<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\BulkUpdateRequest;
use App\Http\Requests\Dashboard\Products\CreateRequest;
use App\Http\Requests\Dashboard\Products\SetCoverRequest;
use App\Http\Requests\Dashboard\Products\UpdateRankingRequest;
use App\Http\Requests\Dashboard\Products\UpdateRequest;
use App\Http\Requests\Dashboard\Products\UpdateStatusRequest;
use App\Http\Requests\Dashboard\Products\UploadGalleryRequest;
use App\Models\Product;
use App\Services\Repositories\ProductCategoryRepository;
use App\Services\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public ProductRepository $repository;
    public ProductCategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
        $this->categoryRepository = new ProductCategoryRepository();

        $this->repository->setLocale('tr');
        $this->categoryRepository->setLocale('tr');
    }

    public function index(Request $request)
    {
        return view('dashboard.products.index', [
            'products' => $this->repository
                ->setPerBy(20)
                ->setEagerRelations(['category'])
                ->filterAllProducts($request->toArray()),
            'categories' => $this->categoryRepository->getAllCategories()
        ]);
    }

    public function create()
    {
        return view('dashboard.products.edit-add', [
            'categories' => $this->categoryRepository->getAllCategories(),
            'product_units' => $this->repository->getProductUnits()
        ]);
    }

    public function store(CreateRequest $request)
    {
        $process = $this->repository->createProduct($request->validated());

        if ($process->success()) {
            session()->flash('toast_success', 'Ürün başarıyla oluşturuldu');
            return redirect()->route('dashboard.products.index');
        } else {
            session()->flash('toast_error', $process->errors()->first());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return abort(404);
        }

        return view('dashboard.products.edit-add', [
            'product' => $product,
            'categories' => $this->categoryRepository->getAllCategories(),
            'product_units' => $this->repository->getProductUnits()
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return abort(404);
        }

        $process = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->updateProduct($request->validated());

        if ($process->success()) {
            session()->flash('toast_success', 'Ürün başarıyla güncellendi');
            return redirect()->route('dashboard.products.index');
        } else {
            session()->flash('toast_error', $process->errors()->first());
            return redirect()->back();
        }
    }

    public function gallery($id)
    {
        $product = $this->repository->setEagerRelations(['galleries'])->findById($id);

        if (!$product) {
            return abort(404);
        }

        return view('dashboard.products.galleries', [
            'product' => $product,
        ]);
    }

    public function uploadGallery(UploadGalleryRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün bulunamadı'
            ]);
        }

        $productGallery = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->uploadGallery($request->file('file'));

        if ($productGallery) {
            return response()->json([
                'status' => true,
                'message' => 'Görsel başarıyla güncellendi',
                'data' => [
                    'id' => $productGallery->id,
                    'small' => asset('storage/' . $productGallery->small_path),
                    'large' => asset('storage/' . $productGallery->large_path),
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => trans('Technical error')
            ]);
        }
    }

    public function setCoverGallery(SetCoverRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün bulunamadı'
            ]);
        }

        $keepOldProductCoverId = $product->galleries()->where('is_cover', 1)->first()?->id;

        $process = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->setCoverGallery($request->input('id'));

        if ($process->success()) {
            return response()->json([
                'status' => true,
                'message' => 'Kapak görseli güncellendi',
                'checked_id' => $request->input('id')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $process->errors()->first(),
                'checked_id' => $keepOldProductCoverId
            ]);
        }
    }

    public function deleteGallery(SetCoverRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün bulunamadı'
            ]);
        }

        $process = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->deleteGallery($request->input('id'));

        if ($process->success()) {
            return response()->json([
                'status' => true,
                'message' => 'Görsel başarıyla silindi',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $process->errors()->first(),
            ]);
        }
    }

    public function updateGalleryRanking(UpdateRankingRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün bulunamadı'
            ]);
        }

        $process = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->updateGalleryRanking($request->input('galleries'));

        if ($process->success()) {
            return response()->json([
                'status' => true,
                'message' => 'Sıralama başarıyla güncellendi',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $process->errors()->first(),
            ]);
        }
    }

    public function updateStatus(UpdateStatusRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün bulunamadı'
            ]);
        }

        $process = $this->repository
            ->setLocale('tr')
            ->setProduct($product)
            ->updateStatus($request->input('is_active'));

        if ($process->success()) {
            return response()->json([
                'status' => true,
                'message' => 'Ürün durumu başarıyla güncellendi',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $process->errors()->first(),
            ]);
        }
    }

    public function delete($id)
    {
        $process = $this->repository
            ->setLocale('tr')
            ->deleteProduct($id);

        if ($process->success()) {
            session()->flash('toast_success', 'Ürün başarıyla kaldırıldı');
            return redirect()->route('dashboard.products.index');
        } else {
            session()->flash('toast_error', $process->errors()->first());
            return redirect()->route('dashboard.products.index');
        }
    }

    public function delete_product_variant(Request $request, $productId, $variantId){
        $process = $this->repository
            ->setLocale('tr')
            ->deleteProductVariant($productId, $variantId);

        if ($process->success()) {
            return response()->json([
              'status' => true,
              'message' => 'Ürün başarıyla kaldırıldı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $process->errors()->first()
            ]);
        }
    }

    public function bulkUpdate(BulkUpdateRequest $request){
        $process = $this->repository
            ->setLocale('tr')
            ->bulkUpdate($request->input('products'), $request->except('products', '_token'));

        if ($process->success()) {
            session()->flash('toast_success', 'Ürünler başarıyla güncellendi');
            return redirect()->route('dashboard.products.index');
        } else {
            session()->flash('toast_error', $process->errors()->first());
            return redirect()->route('dashboard.products.index');
        }
    }

    public function product_categories(){
        return view('dashboard.products.categories.index', [
            'categories' => $this->categoryRepository
                ->setPerBy(20)
                ->setEagerRelations(['category'])
                ->getAllMainCategories(),
        ]);
    }
}
