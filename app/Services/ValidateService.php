<?php 

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateService
{
    /**
     * checkRegisterRequest
     * @param Request $request
     */
    public function checkRegisterRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ],[
            'name.required'      => '姓名為必填',
            'email.required'     => '信箱為必填',
            'email.email'        => '信箱格式錯誤',
            'email.unique'       => '信箱已註冊',
            'password.required'  => '密碼為必填',
            'password.confirmed' => '密碼不一致',
        ]);

        return $validator;
    }

    /**
     * checkLoginRequest
     * @param Request $request
     */
    public function checkLoginRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'    => 'required|email',
            'password' => 'required|string',
        ],[
            'email.required'     => '信箱為必填',
            'email.email'        => '信箱格式錯誤',
            'password.required'  => '密碼為必填',
        ]);

        return $validator;
    }
}