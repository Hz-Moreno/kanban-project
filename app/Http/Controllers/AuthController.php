<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->login($request->validated());
            if ($user) {
                return response()->json(
                    [
                        'status' => 'success',
                        'user' => $user,
                    ],
                    Response::HTTP_CREATED,
                );
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Credenciais inválidas. Verifique seu e-mail e senha.',
            ], Response::HTTP_UNAUTHORIZED);

        } catch (Exception $e) {
            Log::error('L: '.$e->getMessage());

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

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
