<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function createForm()
    {
        return view('form');
    }

    public function getFormData(Request $request)
    {
        $formData = $request->all();
        return $formData;
    }
}
