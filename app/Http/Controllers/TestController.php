<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Products\CreateRequest;
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

    public function test2()
    {
        return view('test.index');
    }

    public function test3(CreateRequest $request){
        $process = $this->productRepository->store($request->validated());

        return dd($process);
    }
}
