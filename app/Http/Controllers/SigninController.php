<?php

namespace App\Http\Controllers;

use App\Http\Requests\SigninRequest;
use App\Models\Signin;
use Illuminate\Http\Request;

class SigninController extends Controller
{
    public function index()
    {
        return view('signin');
    }

    public function store(SigninRequest $request)
    {
        
        $signin = Signin::create($request->validated());
        return $signin;
    }
}


