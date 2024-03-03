<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById(string $userId);
    public function getUserByEmail(string $userEmail);
    public function createUser(array $registerData);
    public function updateUser(string $userId, array $newData);
}