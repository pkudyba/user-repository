<?php


namespace App\Exceptions;


class UserEmailAlreadyExisting extends \Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'user_email_already_exists',
            'message' => 'User with this email already exists.',
            'status' => 'error'
        ], 500);
    }
}
