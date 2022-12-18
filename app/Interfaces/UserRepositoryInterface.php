<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($userId);
    public function getUserByEmail($userEmail);
    public function deleteUser($userId);
    public function createUser(array $registerData);
    public function updateUser($userId, array $newData);
}