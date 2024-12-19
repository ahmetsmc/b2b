<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
                ->filter($request->toArray())
        ]);
    }

    public function create()
    {
        return view('dashboard.products.edit-add', [
            'categories' => $this->categoryRepository->index(),
            'product_units' => $this->repository->getProductUnits()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:250',
            'code' => 'required|unique:products,code',
            'status' => 'required|in:test'
        ]);

        return 'test';
    }
}
