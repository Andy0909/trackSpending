<?php

namespace Tests\Unit;

use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Mockery;

class UserServiceTest extends TestCase
{
    /** @var \Mockery\MockInterface|UserRepository $userRepository */
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the UserRepository
        $this->userRepository = Mockery::mock(UserRepository::class);
    }

    /**
     * @return void
     */
    public function test_getUserById(): void
    {
        $userId = 1;
        $expectedUser = new User([
            'id'    => $userId,
            'name'  => 'Andy',
            'email' => 'test@example.com',
        ]);

        // Set up the mock expectation
        $this->userRepository
            ->shouldReceive('getUserById')
            ->with($userId)
            ->once()
            ->andReturn($expectedUser);

        $userService = new UserService($this->userRepository);

        // Call the service method
        $user = $userService->getUserById($userId);

        // Assert the expected outcome
        $this->assertEquals($expectedUser, $user);
    }

    /**
     * @return void
     */
    public function test_getUserByEmail(): void
    {
        $userEmail = 'test@example.com';
        $expectedUser = new User([
            'id'    => 1,
            'name'  => 'Andy',
            'email' => $userEmail,
        ]);

        // Set up the mock expectation
        $this->userRepository
            ->shouldReceive('getUserByEmail')
            ->with($userEmail)
            ->once()
            ->andReturn($expectedUser);

        $userService = new UserService($this->userRepository);

        // Call the service method
        $user = $userService->getUserByEmail($userEmail);

        // Assert the expected outcome
        $this->assertEquals($expectedUser, $user);
    }

    /**
     * @return void
     */
    public function test_createUser(): void
    {
        $registerData = ['email' => 'test@example.com', 'name' => 'Andy'];
        $expectedUser = new User($registerData);

        // Set up the mock expectation
        $this->userRepository
            ->shouldReceive('createUser')
            ->with($registerData)
            ->once()
            ->andReturn($expectedUser);

        $userService = new UserService($this->userRepository);

        // Call the service method
        $user = $userService->createUser($registerData);

        // Assert the expected outcome
        $this->assertEquals($expectedUser, $user);
    }

    /**
     * @return void
     */
    public function test_updateUserByEmail(): void
    {
        $userEmail = 'test@example.com';
        $updateData = ['name' => 'Andy Wei'];
        $expectedResult = 1;

        // Set up the mock expectation
        $this->userRepository
            ->shouldReceive('updateUserByEmail')
            ->with($userEmail, $updateData)
            ->once()
            ->andReturn($expectedResult);

        $userService = new UserService($this->userRepository);

        // Call the service method
        $result = $userService->updateUserByEmail($userEmail, $updateData);

        // Assert the expected outcome
        $this->assertEquals($expectedResult, $result);
    }
}
