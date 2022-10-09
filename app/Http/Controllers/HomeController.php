<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function createTrackSpendingSystem()
    {
        $user_data = session()->get('response');
        return view('createTrackSpendingSystem', ['user_data' => $user_data]);
    }

    public function getFormData(Request $request)
    {
        $formData = $request->all();
        return $formData;
    }
}
