<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('verify-email');
    }

    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return view('verify')->with(['status'=> 'expired','userId'=>$user_id]);
        }

        $user = User::findOrFail($user_id);

        if ($user->hasVerifiedEmail()) {
            return view('verify')->with('status', 'already-verified');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view('verify')->with('status', 'verified');
    }

    public function resend( Request $request)
    {
        $user = User::findOrFail($request->user_id); 
        if ($user->hasVerifiedEmail()) {
            return response([
                'message' => "Email Already Verified !"
            ], 400);
        }

        $user->sendEmailVerificationNotification();
        return view('verify')->with([
            'message' => "Email verification link sent to : " . $user->email,
            'status'=>"resent"
        ]);

    }
}
