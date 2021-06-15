<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user')){
            toastInfo('You are logging in');
            return redirect()->route('admins.index');
        }
        return view('backend.login.login');
    }

    public function login(LoginRequest $request)
    {
        $userData = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($userData)) {
            $isAdmin = 0;
            $userEmail = $userData['email'];
            $user = User::where('email', '=', $userEmail)->get();
            $userRoles = $user[0]->roles;
            foreach ($userRoles as $role) {
                if ($role->id == 1) {
                    $isAdmin = 1;
                }
            }
            if ($isAdmin == 1) {
                array_push($userData,['id'=>$userRoles]);
                \session()->push('user', $userData);
                toastSuccess('You are logged in','Welcome');
                return redirect()->route('admins.index')->withInput();
            } else {
                return view('backend.permission');
            }
        }
        return redirect()->route('login')->withErrors(['email'=>'Information not correct']);

    }

    public function logout()
    {
        Auth::logout();
        \session()->forget('user');
        return redirect()->route('login');
    }
}
