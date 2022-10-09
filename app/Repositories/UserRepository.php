<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() 
    {
        return User::all();
    }

    public function getUserById($userId) 
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

    public function createUser(array $registerData) 
    {
        return User::create($registerData);
    }

    public function updateUser($userId, array $newData) 
    {
        return User::whereId($userId)->update($newData);
    }
}