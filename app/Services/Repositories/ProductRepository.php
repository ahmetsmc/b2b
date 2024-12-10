<?php

namespace App\Services\Repositories;

use App\Http\Requests\Dashboard\Products\CreateRequest;
use App\Models\Product;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductInterface
{
    public string $locale;

    public object $errors;

    public Product|null $product = null;

    public function __construct()
    {
        $this->locale = config('app.default_locale');

        $this->errors = new Collection();
    }

    public function index(): Collection
    {
        return Product::all();
    }

    public function store($request): static
    {
        $this->product = Product::create($request);

        return $this;
    }

    public function product(): ?Product
    {
        return $this->product;
    }

    public function success(): bool
    {
        return count($this->errors) < 1;
    }

    public function setError($content): static
    {
        $this->errors->push($content);

        return $this;
    }

    public function errors(): Collection
    {
        return $this->errors;
    }
}
