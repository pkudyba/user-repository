<?php


namespace App\Services;


use App\Models\User;

interface UserServiceInterface
{
    public function createUser(string $name, string $email, string $password): User;

    public function listUsers(?string $name, ?string $email);

    public function activation(int $userId, bool $active): User;
}
