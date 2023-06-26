<?php
namespace App\Interfaces;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout( $token);
    public function forgotPassword(array $data);
    public function resetPassword(array $data);
}
