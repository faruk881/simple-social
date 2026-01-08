<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function userRegister(Request $request) {
        $fields = $request->validate([ 
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $fields['password'] = Hash::make($fields['password']);

        $user = User::create($fields);

        $otpResult = send_email_otp($user);

        if (!$otpResult['success']) {

            // Optional rollback
            $user->delete();

            return response()->json([
                'status'  => 0,
                'message' => 'Failed to send OTP email',
                'error'   => app()->isLocal()
                    ? $otpResult['error']   // FULL error (local/dev)
                    : null                  // hidden in production
            ], 500);
        }

        return response()->json([
            'status'  => 1,
            'message' => 'User created successfully. OTP sent to email.'
        ], 201);
    }


    public function mailVerify(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !$user->otp ||
            !Hash::check($request->otp, $user->otp) ||
            Carbon::now()->gt($user->otp_expires_at)
        ) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid or expired OTP, Try to log in to get new otp'
            ], 400);
        }

        $user->update([
            'otp' => null,
            'email_verified_at' => Carbon::now(),

        ]);

        return response()->json([
            'status' => 1,
            'message' => 'email successfully verified, now you can log in'
        ]);


    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();

        if(!$user->email_verified_at){

            if (send_email_otp($user)){
                return response()->json([
                    'status' => 1,
                    'message' => 'Hellow! '.$user->name .'. An otp sent to '.$user->email.'Please verify first to log in.'
                ]);
            }
        }

        if(!$user || !Hash::check($request->password,
        $user->password)) {
            return response()->json([
                'message' => "invalid credentials",

            ]);
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'You are logged out'
        ]);
    }
}
