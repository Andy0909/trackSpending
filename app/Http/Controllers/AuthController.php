<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\SessionService;
use App\Services\ValidateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    const REGISTER_SUCCESS_MESSAGE = '註冊成功，趕快登入建立分帳系統吧！';

    const PASSWORD_ERROR_MESSAGE = '密碼輸入錯誤';

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
        $validator = $this->validateService->checkRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
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
        $registerSuccessMessage = is_null(session()->get('registerSuccessMessage')) ? '' : session()->get('registerSuccessMessage');

        return view('login')->with(['registerSuccessMessage' => $registerSuccessMessage]);
    }

    /**
     * loginProcess
     * @param Request $request
     */
    public function loginProcess(Request $request)
    {
        $loginData = $request->all();

        try {
            $user = $this->userRepository->getUserByEmail($loginData['email']);

            if (!$user || !Hash::check($loginData['password'], $user->password)) {
                return redirect()->back()->withErrors(self::PASSWORD_ERROR_MESSAGE)->withInput();
            }

            $token = $user->createToken('token')->plainTextToken;
            $userData = [
                'userId'    => $user->id,
                'userName'  => $user->name,
                'userEmail' => $user->email,
                'token'     => $token,
            ];
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
            $user = $this->userRepository->getUserById($request->all()['userId']);
            $user->tokens()->delete();
            $this->sessionService->removeSession();
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(self::ERROR_MESSAGE);
        }

        return redirect('/login');
    }
}
