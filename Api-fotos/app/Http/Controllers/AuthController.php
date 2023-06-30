<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Request\RegisterRequest;
use App\Http\Request\LoginRequest;
use App\Http\Request\ForgotPasswordRequest;
use App\Http\Request\ResetPasswordRequest;
use Illuminate\Http\Request;
class AuthController extends Controller
{
  public function register(RegisterRequest $request, AuthService $authService)
    {
        return $authService->register($request->validated());
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        return $authService->login($request->validated());
    }
    public function logout(AuthService $authService)
    {
    
        return $authService->logout();
    }

    public function forgotPassword(ForgotPasswordRequest $request, AuthService $authService)
    {
        return $authService->forgotPassword($request->validated());
    }

    public function resetPassword(ResetPasswordRequest $request, AuthService $authService)
    {
        return $authService->resetPassword($request->validated());
    }
}
