<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Auth\LoginRequest;
use App\Http\Requests\Dashboard\Products\CreateRequest;
use App\Models\Product;
use App\Services\Repositories\AuthRepository;
use App\Services\Repositories\ProductRepository;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function test(CreateRequest $request)
    {
        $process = $this->productRepository->store($request->validated());

        return dd($process->success(), $process->errors());
    }

    public function test2(LoginRequest $request)
    {
        $authRepository = new AuthRepository();
        $attempt = $authRepository->setLocale('tr')->attempt(
            $request->validated('email'),
            $request->validated('password'),
        );

        if ($attempt->success()){
            return $attempt->getUser();
        }else{
            return $attempt->errors()->first();
        }

        $product = Product::latest()->first();

        return [$product->unit, $product->id];
        return view('test.index');
    }

    public function test3(CreateRequest $request)
    {
        $process = $this->productRepository->store($request->validated());

        return dd($process);
    }

    public function test4()
    {
        $process = $this->productRepository->update(5, ['test']);
    }

    public function test5()
    {
        $process = $this->productRepository->delete(5);
    }
}
