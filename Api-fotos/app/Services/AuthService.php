<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Activitylog\Facades\Activity;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function register(array $data)
    {
        try {
            
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'code' => 200,
                'message' => 'Registered successfully',
                'data' => [
                    'token' => $token,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Registration failed',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    public function login(array $credentials)
    {
        try {
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $user = User::where('email', $credentials['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'code' => 200,
                'message' => 'Logged in successfully',
                'data' => [
                    'token' => $token,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Login failed',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    
    public function logout($token)
    {
        try {
            $token->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Logged out successfully',
            ]);

        
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Logout failed',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
    public function forgotPassword(array $data)
    {
        try {
            $status = Password::sendResetLink($data);
    
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Password reset link sent',
                    'token' => $status
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Unable to send password reset link',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Forgot password failed',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }    
    public function resetPassword(array $data)
    {
        try {
            $status = Password::reset($data, function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            });

            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Password reset successfully',
                ]);
            } else {
                throw new \Exception('Some error message here');
                /*return response()->json([
                    'code' => 400,
                    'message' => 'Unable to reset password',
                ], 400);*/
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Reset password failed',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}
