<?php

namespace App\Http\Controllers\API;
use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $request->validate([
        'name' => ['required', 'string', 'min:3', 'max:30'],
        'email'=> ['required', 'email', 'unique:users,email'],
        'role'=>['required'],
        'password'=> ['required','min:8', 'confirmed'],
        'password_confirmation' => ['required']
        ]);

        if($request->role == 0){
            // if the user is a client
            $request->validate(['address'=>['required'],]);
        }
        // Create user and generate token
        // utilisation d'Action Register
        
        $register = new register();
        //return response()->noContent($register($request) ? 204 : 205);
        $response = response()->noContent($register($request) ? 204 : 205);
        return response()->json("user created",201);
    }
    public function login(LoginRequest $request)
    {
        $login = new Login();

        return response()
            ->json($login($request), 200);
    }

    public function logout(Request $request)
    {
        $logout = new Logout();

        return response()->noContent($logout($request) ? 204 : 205);
    }

}
