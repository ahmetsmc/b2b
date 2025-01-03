<?php

namespace App\Services\Repositories;

use App\Models\ProductCategory;
use App\Models\User;
use App\Traits\HasRepositoryRoof;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryRepository
{
    use HasRepositoryRoof;

    public ProductCategory|null $productCategory = null;

    public function getAllCategories(): Collection
    {
        return ProductCategory::all();
    }

    public function createProductCategory($data): static
    {
        $this->productCategory = ProductCategory::create($data);

        return $this;
    }

    public function updateProductCategory(int $id, array $data): static
    {
        $productCategory = ProductCategory::find($id);

        if (!$productCategory) {
            $this->setError(__('Product Category Not Found'));
            return $this;
        }

        $productCategory->update($data);

        return $this;
    }

    public function deleteProductCategory(int $id): static
    {
        $productCategory = ProductCategory::find($id);

        if (!$productCategory) {
            $this->setError(__('Product Not Found'));
            return $this;
        }

        if (true != false) {
            // TODO: ürün silmek için herhangi bir engel var mı kontrol edilmeli
            // örneğin herhangi bir siparişteyse
        }

        $productCategory->delete();

        return $this;
    }

    public function productCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    public function getAllMainCategories()
    {
        return ProductCategory::filterParent()->with($this->withEagerLoads)->paginate($this->perBy);
    }
}
