<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * construct
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 使用 id 取得用戶資料
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User
    {
        return $this->userRepository->getUserById($userId);
    }

    /**
     * 使用 email 取得用戶資料
     * @param string $userEmail
     * @return User
     */
    public function getUserByEmail(string $userEmail): User
    {
        return $this->userRepository->getUserByEmail($userEmail);
    }
    
    /**
     * 創建用戶
     * @param array $registerData
     * @return User
     */
    public function createUser(array $registerData): User
    {
        return $this->userRepository->createUser($registerData);
    }
}