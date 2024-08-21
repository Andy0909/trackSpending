<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use App\Services\UserService;
use App\Services\ValidateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    /** @const string */
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    /** @const string */
    const REGISTER_SUCCESS_MESSAGE = '註冊成功，趕快登入建立分帳系統吧！';

    /** @const string */
    const PASSWORD_ERROR_MESSAGE = '帳號密碼輸入錯誤。';

    /** @var SessionService */
    private $sessionService;

    /** @var UserService */
    private $userService;

    /** @var ValidateService */
    private $validateService;
    
    /**
     * @param SessionService $sessionService
     * @param UserService $userService
     * @param ValidateService $validateService
     */
    public function __construct(SessionService $sessionService, UserService $userService, ValidateService $validateService) 
    {
        $this->sessionService = $sessionService;
        $this->userService = $userService;
        $this->validateService = $validateService;
    }

    /**
     * 註冊頁
     */
    public function registerPage()
    {
        return view('register');
    }

    /**
     * 註冊會員
     * @param Request $request
     */
    public function registerProcess(Request $request)
    {
        // 檢查用戶註冊輸入資料
        $validator = $this->validateService->checkRegisterRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            // 新增新用戶
            $this->userService->createUser([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->route('loginPage')->with('registerSuccessMessage', self::REGISTER_SUCCESS_MESSAGE);
    }

    /**
     * 登入頁
     */
    public function loginPage()
    {
        // 取 session 資料
        $userName = $this->sessionService->getSession('userName');
        $userId = $this->sessionService->getSession('userId');
        $token = $this->sessionService->getSession('token');

        // 若 session 已有資料則導到新增分帳系統頁面
        if (!empty($userName) && !empty($userId) && !empty($token)) {
            return redirect()->route('createEventPage');
        }

        $registerSuccessMessage = is_null(session()->get('registerSuccessMessage')) ? '' : session()->get('registerSuccessMessage');

        return view('login')->with(['registerSuccessMessage' => $registerSuccessMessage]);
    }

    /**
     * 登入會員
     * @param Request $request
     */
    public function loginProcess(Request $request)
    {
        // 檢查用戶登入輸入資料
        $validator = $this->validateService->checkLoginRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 取得用戶輸入資料
        $loginData = $request->all();

        try {
            // 使用信箱取得用戶資料
            $user = $this->userService->getUserByEmail($loginData['email']);

            // 若找不到用戶或密碼錯誤則回登入頁
            if (!$user || !Hash::check($loginData['password'], $user->password)) {
                return redirect()->back()->withErrors(self::PASSWORD_ERROR_MESSAGE)->withInput();
            }

            // 產生用戶 token
            $token = $user->createToken('token')->plainTextToken;

            // token 寫入資料庫
            $this->userService->updateUserByEmail($user->email, ['remember_token' => $token,]);

            // 用戶資料
            $userData = [
                'userId'    => $user->id,
                'userName'  => $user->name,
                'userEmail' => $user->email,
                'token'     => $token,
            ];

            // 將用戶資料存進 session
            $this->sessionService->setSession($userData);
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(self::ERROR_MESSAGE)->withInput();
        }

        return redirect()->route('createEventPage');
    }

    // github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // github callback
    public function handleGithubCallback()
    {
        $userData = Socialite::driver('github')->user();

        $result = $this->createUserFromSocialite($userData);

        return $result ? redirect()->route('createEventPage') : redirect('/');
    }

    // google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // google callback
    public function handleGoogleCallback()
    {
        $userData = Socialite::driver('google')->user();

        $result = $this->createUserFromSocialite($userData);

        return $result ? redirect()->route('createEventPage') : redirect('/');
    }

    /**
     * 第三方登入
     *
     * @param $userData
     * @return boolean
     */
    private function createUserFromSocialite($userData): bool
    {
        try {
            $user = $this->userService->getUserByEmail($userData->email);

            if (!$user) {
                $user = $this->userService->createUser([
                    'name' => $userData->name,
                    'email' => $userData->email,
                ]);
            }

            dd($user);

            // 產生用戶 token
            $token = $user->createToken('token')->plainTextToken;

            // token 寫入資料庫
            $this->userService->updateUserByEmail($user->email, ['remember_token' => $token,]);

            // 用戶資料
            $userData = [
                'userId'    => $user->id,
                'userName'  => $user->name,
                'userEmail' => $user->email,
                'token'     => $token,
            ];

            // 將用戶資料存進 session
            $this->sessionService->setSession($userData);

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * logout
     * @param Request $request
     */
    public function logout(Request $request)
    {
        try {
            // 使用 id 取得用戶資料
            $user = $this->userService->getUserById($request->all()['userId']);

            // 刪除用戶 token
            $user->tokens()->delete();

            // 刪除用戶 session
            $this->sessionService->removeSession();
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect('/');
    }
}