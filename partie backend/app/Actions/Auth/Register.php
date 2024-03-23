<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Admin;
use App\Models\Client;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function __invoke(RegisterRequest $request)
    {
        $data = DB::transaction(function () use ($request) {
            $password = Hash::make($request->input('password'));

            $user = User::create([
                'name'  =>  $request->input('name'),
                'email' =>  $request->input('email'),
                'password' =>  $password,
                'role'=>$request->role
            ]);

            //return $user ;
            $user->sendEmailVerificationNotification();


            abort_if(!$user, 400, 'Could not Register !');
                    // Déterminer le rôle et créer l'enregistrement associé
            if ($request->role == 0) {
                // Créer un client
                $client = Client::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'user_id' => $user->id,
                ]);
            } elseif ($request->role == 1) {
                // Créer un admin
                $admin = Admin::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                ]);
            }

            event(new Registered($user));

            $token = $user->createToken('#authToken')->plainTextToken;
            $token = explode('|', $token, 2)[1];

            return [
                'user'  =>  $user,
                'token' =>  $token,
            ];
        });

        return $data;
    }
}
