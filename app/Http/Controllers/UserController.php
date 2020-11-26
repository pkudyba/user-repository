<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\UserServiceInterface;

class UserController extends Controller
{
    public function index(Request $request, UserServiceInterface $userService)
    {
        return $userService->listUsers($request->get('name'), $request->get('email'));
    }

    public function store(Request $request, UserServiceInterface $userService)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email|min:4|max:255',
            'password' => 'required|string|min:4|max:20'
        ]);

        return $userService->createUser(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );
    }

    public function activate(int $userId, UserServiceInterface $userService)
    {
        $userService->activation($userId, true);

        return response()->json([], 200);
    }

    public function deactivate()
    {

    }
}
