<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function createEmployee(RegisterRequest $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role_id !== 'manager') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validated = $request->validated();

        $employee = Employee::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'manager_id' => $user->id
        ]);

        $employee->notify(new EmployeeCreated($employee));

        return response()->json(['employee' => $employee], 201);
    }
}
