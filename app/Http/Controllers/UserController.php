<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, UserServiceInterface $userService)
    {
        return $userService->listUsers($request->get('name'), $request->get('email'));
    }

    public function store(StoreUserRequest $request, UserServiceInterface $userService)
    {
        $user = $userService->createUser(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return response()->json([
            "data" => $user
        ], 200);
    }

    public function activate(int $userId, UserServiceInterface $userService)
    {
        $userService->activation($userId, true);

        return response()->json([], 200);
    }

    public function deactivate(int $userId, UserServiceInterface $userService)
    {
        $userService->activation($userId, false);

        return response()->json([], 200);
    }
}
