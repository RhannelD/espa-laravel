<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signin(AuthRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return Auth::user()->createToken('API')->plainTextToken;
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
