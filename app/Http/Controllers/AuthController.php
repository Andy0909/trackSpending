<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\SessionService;
use App\Services\ValidateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    /** @const string */
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    /** @const string */
    const REGISTER_SUCCESS_MESSAGE = '註冊成功，趕快登入建立分帳系統吧！';

    /** @const string */
    const PASSWORD_ERROR_MESSAGE = '密碼輸入錯誤。';

    /** @var  UserRepository */
    private $userRepository;

    /** @var  SessionService */
    private $sessionService;

    /** @var  ValidateService */
    private $validateService;
    
    /**
     * @param UserRepository $userRepository
     * @param SessionService $sessionService
     * @param ValidateService $validateService
     */
    public function __construct(UserRepository $userRepository, SessionService $sessionService, ValidateService $validateService) 
    {
        $this->userRepository = $userRepository;
        $this->sessionService = $sessionService;
        $this->validateService = $validateService;
    }

    public function registerPage()
    {
        return view('register');
    }

    /**
     * registerProcess
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
            $this->userRepository->createUser([
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
     * loginProcess
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
            $user = $this->userRepository->getUserByEmail($loginData['email']);

            // 若找不到用戶或密碼錯誤則回登入頁
            if (!$user || !Hash::check($loginData['password'], $user->password)) {
                return redirect()->back()->withErrors(self::PASSWORD_ERROR_MESSAGE)->withInput();
            }

            // 產生用戶 token
            $token = $user->createToken('token')->plainTextToken;

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

    /**
     * logout
     * @param Request $request
     */
    public function logout(Request $request)
    {
        try {
            // 使用 id 取得用戶資料
            $user = $this->userRepository->getUserById($request->all()['userId']);

            // 刪除用戶 token
            $user->tokens()->delete();

            // 刪除用戶 session
            $this->sessionService->removeSession();
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect('/login');
    }
}
