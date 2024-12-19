<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use App\Services\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public AuthRepository $authRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository();
        $this->authRepository->setLocale(app()->getLocale());
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }

        return view('dashboard.auth.login');
    }

    public function attempt(LoginRequest $request)
    {
        $attempt = $this->authRepository->attempt(
            $request->validated('email'),
            $request->validated('password'),
        );

        if ($attempt->success()) {
            return redirect()->route('dashboard.index');
        } else {
            return back()->withErrors($attempt->errors());
        }
    }
}
