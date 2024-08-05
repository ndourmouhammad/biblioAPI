<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Login API - POST (email, password)
     public function login(Request $request){

        // Validation
        $validator = validator($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $tocken = auth()->attempt($credentials);

        // dd($tocken);

        if(!$tocken){
            return response()->json(["message" => "Informations incorrects"], 401);
        }

        return response()->json([
            "access_token" => $tocken,
            "token_type" => "Bearer",
            "user" => auth()->user(),
            "expires_in" => env('JWT_TTL')*60 . " secondes"
        ]);

    }

    // Logout API - POST
    public function logout(){
        auth()->logout();
        return response()->json(["message" => "Vous avez bien été deconnecté"]);
    }

    // Refresh API - POST
    public function refreshToken(){

        $token = auth()->refresh();

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => auth()->user(),
            "expires_in" => env('JWT_TTL')*60 . " secondes"
        ]);
    }
}
