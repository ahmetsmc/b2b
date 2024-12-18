<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
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
        return view('dashboard.products.create');
    }
}
