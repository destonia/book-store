<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginService
{
    public function login($userData)
    {
        if (Auth::attempt($userData)) {
            $user = DB::table('users')->where('email', '=', $userData['email'])->get();
            \session()->push(
                'customer',
                [
                    'id' =>$user[0]->id,
                    'name' => $user[0]->name,
                    'email' => $user[0]->email,
                    'phone' => $user[0]->phone,
                    'address' => $user[0]->address,
                ]);
            toastSuccess('You are logged in', 'Welcome');
            return true;
        } else {
            toastError('Given information not correct', 'Wrong info');
            return false;
        }
    }
}
