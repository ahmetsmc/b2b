<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Services\Interfaces\ProductInterface;
use App\Traits\HasRepositoryRoof;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductInterface
{
    use HasRepositoryRoof;

    public Product|null $product = null;

    public function index()
    {
        return Product::paginate($this->perBy);
    }

    public function filter(array $data = [])
    {
        return Product::when(isset($data['q']), function ($query) use ($data) {
            $query->where('title', 'LIKE', '%' . $data['q'] . '%');
        })->when(isset($data['category_id']), function ($query) use ($data) {
            $query->where('category_id', $data['category_id']);
        })->paginate($this->perBy);
    }

    public function store($request): static
    {
        $this->product = Product::create($request);

        return $this;
    }

    public function update(int $id, array $data): static
    {
        $product = Product::find($id);

        if (!$product) {
            $this->setError(__('Product Not Found'));
            return $this;
        }

        $product->update($data);

        return $this;
    }

    public function delete(int $id): static
    {
        $product = Product::find($id);

        if (!$product) {
            $this->setError(__('Product Not Found'));
            return $this;
        }

        if (true != false) {
            // TODO: ürün silmek için herhangi bir engel var mı kontrol edilmeli
            // örneğin herhangi bir siparişteyse
        }

        $product->delete();

        return $this;
    }

    public function product(): ?Product
    {
        return $this->product;
    }
}
