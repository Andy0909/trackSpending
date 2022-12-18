<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    const ERROR_MESSAGE = '網頁發生錯誤，請稍後再試，謝謝。';

    private $userRepository;
    private $sessionService;
    
    public function __construct(UserRepository $userRepository, SessionService $sessionService) 
    {
        $this->userRepository = $userRepository;
        $this->sessionService = $sessionService;
    }

    public function registerPage()
    {
        return view('register');
    }

    public function registerProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ],[
            'password.confirmed' => '密碼不一致',
            'email.unique'       => '信箱已註冊',
        ]);

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

        return redirect()->route('login')->with('registerSuccessMessage', '註冊成功，趕快登入建立分帳系統吧！');
    }

    public function loginPage()
    {
        $registerSuccessMessage = is_null(session()->get('registerSuccessMessage')) ? '' : session()->get('registerSuccessMessage');

        return view('login')->with(['registerSuccessMessage' => $registerSuccessMessage]);
    }

    public function loginProcess(Request $request)
    {
        $loginData = $request->all();

        try {
            $user = $this->userRepository->getUserByEmail($loginData['email']);

            if (!$user || !Hash::check($loginData['password'], $user->password)) {
                return redirect()->back()->withErrors('密碼輸入錯誤')->withInput();
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
