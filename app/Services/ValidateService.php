<?php 

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateService
{
    public function checkRequest(Request $request): object
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ],[
            'password.confirmed' => '密碼不一致',
            'email.unique'       => '信箱已註冊',
        ]);

        return $validator;
    }
}