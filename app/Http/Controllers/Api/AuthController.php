<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiAuthResourceFailed;
use App\Http\Resources\ApiAuthResourceSuccess;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return new ApiAuthResourceFailed($validator->errors(), 'Something wrong', 422);
        }

        $credentials = $request->only('username', 'password');

        if (!$user = Auth::attempt($credentials)) {
            return new ApiAuthResourceFailed('Username and password wrong', 'Something wrong', 400);
        }

        $user = Auth::user();

        $token = $user->createToken('authToken')->plainTextToken;

        return new ApiAuthResourceSuccess($token, 'Login successfully', 200);
    }

    public function register()
    {
        //
    }
}
