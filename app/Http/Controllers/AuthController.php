<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Exception;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) 
    {
        $this->userRepository = $userRepository;
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
            return response([
                'code'    => 400,
                'message' => $validator->errors(),
            ]);
        }
        try {
            $this->userRepository->createUser([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $response = [
                'code'    => 201,
                'message' => '註冊成功，趕快登入建立分帳系統吧！',
            ];
        }
        catch (Exception $e) {
            $response =[
                'code'    => 500,
                'message' => $e->getMessage(),
            ];
            return response($response);
        }
        return redirect('/');
    }

    public function login()
    {
        return view('login');
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
                $response =[
                    'code' => 401,
                    'message' => '登入失敗',
                ];
                return response($response);
            }
            
            $token = $user->createToken('token')->plainTextToken;
            $response =[
                'code' => 201,
                'userId' => $user->id,
                'userName' => $user->name,
                'userEmail' => $user->email,
                'token' => $token,
            ];
        }
        catch(Exception $e){
            $response =[
                'code'    => 500,
                'message' => $e->getMessage(),
            ];
            return response($response);
        }
        return redirect()->route('createTrackSpendingSystem')->with('response',$response);
    }

    public function logout(Request $request)
    {
        try{
            $user = $this->userRepository->getUserById($request->all()['userId']);
            $user->tokens()->delete();
        }
        catch(Exception $e){
            $response =[
                'message' => $e->getMessage()
            ];
            return response($response);
        }
        $response =[
            'code' => 201,
            'message' => '您已登出'
        ];
        return redirect('/login');
    }
}
