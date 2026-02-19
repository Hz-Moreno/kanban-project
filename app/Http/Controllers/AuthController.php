<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $session = $this->authService->login($request->validated());

            return response()->json(
                [
                    'status' => 'success',
                    'user' => $session['user'],
                    'token' => $session['token'],
                ],
                Response::HTTP_CREATED,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error on process request!',
                    'error' => null,
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'User Created!',
                    'data' => $user,
                ],
                Response::HTTP_CREATED,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error on process request!',
                    'error' => null,
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
