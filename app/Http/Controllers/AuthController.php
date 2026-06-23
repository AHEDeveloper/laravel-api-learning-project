<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            ApiResponseClass::apiResponse(false, 'validation failed', $validator->errors(), 422);
        }

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        $token = $user->createToken('test')->plainTextToken;
        $user['token'] = $token;
        return ApiResponseClass::apiResponse(true, 'create token and user successful', $user, 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation failed', $validator->errors(), 422);
        }
        $user = User::query()->where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password,$user->password))
        {
            return ApiResponseClass::apiResponse(false, 'the provided credentials are incorect', null, 422);
        }

        $token = $user->createToken('test')->plainTextToken;
        $user['token'] = $token;
        return ApiResponseClass::apiResponse(true, 'create token and user successful', $user, 200);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logout']);
    }

    public function logoutWithTokens()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'logout']);
    }
    public function logoutSpecificToken($tokenId)
    {
        auth()->user()->tokens()->where('id',$tokenId)->delete();
        return response()->json(['message' => 'logout']);
    }
}
