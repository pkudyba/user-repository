<?php

namespace Services;

use App\Models\User;

class UserService implements UserServiceInterface
{
    public function createUser(string $name, string $email, string $password): User
    {
        return User::create([
            "name" => $name,
            "email" => $email,
            "is_active" => false,
            "password" => bcrypt($password),
        ]);
    }

    public function listUsers(?string $name, ?string $email)
    {
        return User::query()
            ->when(!empty($name), function ($query) use ($name) {
                $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when(!empty($email), function ($query) use ($email) {
                $query->where('name', 'LIKE', "%{$email}%");
            })
            ->paginate();
    }

    public function activation(User $user, bool $active): User
    {
        $user->update([
            "is_active" => $active,
        ]);

        return $user;
    }

}
