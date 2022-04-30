<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegiesterRequest;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function user()
    {
        return request()->user( );
    }

    public function register(UserRegiesterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }
}
