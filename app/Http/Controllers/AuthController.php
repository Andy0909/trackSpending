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
    private $userRepository;
    private $sessionService;

    public function __construct(UserRepository $userRepository, SessionService $sessionService) 
    {
        $this->userRepository = $userRepository;
        $this->sessionService = $sessionService;
    }

    public function register()
    {
        return view('register');
    }

    public function getRegisterData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        try {
            $this->userRepository->createUser([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
        }
        catch (Exception $e) {
            return redirect()->back()->with(['errors' => $e->getMessage()]);
        }

        return redirect()->route('login')->with('message', '註冊成功，趕快登入建立分帳系統吧！');
    }

    public function login()
    {
        $message = is_null(session()->get('message')) ? '' : session()->get('message');

        return view('login')->with(['message' => $message]);
    }

    public function getLoginData(Request $request)
    {
        $form = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try{
            $user = User::where('email','=',$form['email'])->first();
            if(!$user || !Hash::check($form['password'],$user->password)){
                return response('登入失敗');
            }
            
            $token = $user->createToken('token')->plainTextToken;

            $response =[
                'userId' => $user->id,
                'userName' => $user->name,
                'userEmail' => $user->email,
                'token' => $token,
            ];

            $this->sessionService->setSession($response);
        }
        catch(Exception $e){
            return redirect()->back()->with(['errors' => $e->getMessage()]);
        }
        return redirect()->route('createTrackSpendingSystem')->with('response',$response);
    }

    public function logout(Request $request)
    {
        try{
            $user = $this->userRepository->getUserById($request->all()['userId']);
            $user->tokens()->delete();
            $this->sessionService->removeSession();
        }
        catch(Exception $e){
            return redirect()->back()->with(['errors' => $e->getMessage()]);
        }
        return redirect('/login');
    }
}
