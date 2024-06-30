<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    

    public function register(Request $request){
        $validated = $request->validate([
            'email'=>"required|email",
            'name'=>"required|string|min:3|max:50",
            "password"=>"required|min:8|confirmed",
            "device_name"=>'required'
        ]);


        $user = User::create($validated);

        // Auth::login($user);

        // getting token
        return $user->createToken($request->device_name)->plainTextToken;
    }


    public function login(Request $request) : string {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }


    public function logout(Request $request)  {
        $user = User::where('email', $request->email)->first();


        if($user){
            $user->tokens()->delete();
        }



        return response()->noContent();
    }

}
