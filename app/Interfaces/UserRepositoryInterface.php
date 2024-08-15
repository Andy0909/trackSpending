<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface 
{
    /**
     * 使用 id 取得用戶資料
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User;

    /**
     * 使用 email 取得用戶資料
     * @param string $userEmail
     * @return User
     */
    public function getUserByEmail(string $userEmail): User;

    /**
     * 創建用戶
     * @param array $registerData
     * @return User
     */
    public function createUser(array $registerData): User;
}