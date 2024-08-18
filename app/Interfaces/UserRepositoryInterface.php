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
     * @return User|null
     */
    public function getUserByEmail(string $userEmail): User|null;

    /**
     * 創建用戶
     * @param array $registerData
     * @return User
     */
    public function createUser(array $registerData): User;

    /**
     * 更新用戶資料
     * @param string $userEmail
     * @param array $updateData
     * @return int
     */
    public function updateUserByEmail(string $userEmail, array $updateData): int;
}