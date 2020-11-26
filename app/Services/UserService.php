<?php

namespace App\Services;

use App\Events\UserCreatedEvent;
use App\Exceptions\UserEmailAlreadyExisting;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function findIfEmailExists(string $email): bool
    {
       $users = User::query()
           ->where('email', '=', $email)
           ->get();

       return $users->isNotEmpty();
    }

    public function createUser(string $name, string $email, string $password): User
    {
       if($this->findIfEmailExists($email)) {
           throw new UserEmailAlreadyExisting();
       }

        $user = User::create([
            "name" => $name,
            "email" => $email,
            "is_active" => false,
            "password" => bcrypt($password),
        ]);
        UserCreatedEvent::dispatch();
        User::flushQueryCache();

        return $user;
    }

    public function listUsers(
        ?string $name,
        ?string $email,
        string $orderColumn,
        string $orderDirection,
        int $pageNumber = 1
    ) {
        return User::cacheFor(env('CACHE_TIME'))
            ->when(!empty($name), function ($query) use ($name) {
                $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when(!empty($email), function ($query) use ($email) {
                $query->where('name', 'LIKE', "%{$email}%");
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50, ['*'], 'page', $pageNumber);
    }

    public function activation(int $userId, bool $active): User
    {
        $user = User::findOrFail($userId);
        $user->update([
            "is_active" => $active,
        ]);

        return $user;
    }
}
