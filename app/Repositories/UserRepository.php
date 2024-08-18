<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    /** @var User */
    private $userModel;

    /**
     * construct
     * @param User $userModel
     */
    public function __construct(User $userModel) 
    {
        $this->userModel = $userModel;
    }

    /**
     * 使用 id 取得用戶資料
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User
    {
        return $this->userModel->findOrFail($userId);
    }

    /**
     * 使用 email 取得用戶資料
     * @param string $userEmail
     * @return User|null
     */
    public function getUserByEmail(string $userEmail): User|null
    {
        return $this->userModel->where('email', $userEmail)->first();
    }

    /**
     * 創建用戶
     * @param array $registerData
     * @return User
     */
    public function createUser(array $registerData): User
    {
        return $this->userModel->create($registerData);
    }

    /**
     * 更新用戶資料
     * @param string $userEmail
     * @param array $updateData
     * @return int
     */
    public function updateUserByEmail(string $userEmail, array $updateData): int
    {
        return $this->userModel
            ->where('email', $userEmail)
            ->update($updateData);
    }
}