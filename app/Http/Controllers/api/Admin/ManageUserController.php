<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    public function showUsers() {

        $users = User::select('id','name','email','email_verified_at','user_type')->get();

        return response()->json([
            "status" => "Success",
            "message" => "Done",
            "data" => $users
        ]);
    }

    public function showPendingUsers(){
        $users = User::where('user_type','pending')->select('id','name','email','email_verified_at','user_type')->get();
        return response()->json([
            "status" => "Success",
            "message" => "Done",
            "data" => $users
        ]);
    }

    public function approveUsers($id) {

        $user = User::findOrFail($id);
        
        // prevent changing existing persmission another.
        if ($user->user_type === 'admin') {
            return response()->json([
                'status'  => 'Error',
                'message' => 'User is already an admin'
            ], 400);
        }
        if ($user->user_type === 'approved') {
            return response()->json([
                'status'  => 'Error',
                'message' => 'User is already approved'
            ], 400);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'The users mail is not verified'
            ]);
        }

        $user->update([
            'user_type' => 'approved'
        ]);

        return response()->json([
            'status'  => 'Success',
            'message' => 'User approved',
            'data'    => $user->only([
                'id',
                'name',
                'email',
                'user_type',
                'email_verified_at',
            ])
        ]);
    }
    public function deleteUsers($id) {

        $user = User::findOrFail($id);
        $user->delete();
        
        // prevent changing existing persmission another.
        

        return response()->json([
            'status'  => 'Success',
            'message' => 'User deleted',
            'data'    => $user->only([
                'id',
                'name',
                'email',
                'user_type',
                'email_verified_at',
            ])
        ]);
    }


}
