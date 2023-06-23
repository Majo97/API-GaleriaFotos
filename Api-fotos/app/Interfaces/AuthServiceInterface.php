<?php
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;

interface AuthServiceInterfacesail 
{
    /**
     * Register a new user. 
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse;

    /**
     * Log in an existing user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse;

    /**
     * Log out the authenticated user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse;

    /**
     * Send a password reset link to the user's email.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */ 
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse;

    /**
     * Reset the user's password.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse;
}
