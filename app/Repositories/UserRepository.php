<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    /**
     * 取得所有用戶資料
     */
    public function getAllUsers() 
    {
        return User::all();
    }

    /**
     * 使用 id 取得用戶資料
     * @param string $userId
     */
    public function getUserById(string $userId) 
    {
        return User::findOrFail($userId);
    }

    /**
     * 使用 email 取得用戶資料
     * @param string $userEmail
     */
    public function getUserByEmail(string $userEmail) 
    {
        return User::where('email', '=', $userEmail)->first();
    }

    /**
     * 創建用戶資料
     * @param array $registerData
     */
    public function createUser(array $registerData) 
    {
        return User::create($registerData);
    }

    /**
     * 更新用戶資料
     * @param string $userId
     * @param array $registerData
     */
    public function updateUser(string $userId, array $newData) 
    {
        return User::whereId($userId)->update($newData);
    }
}