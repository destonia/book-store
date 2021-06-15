<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Services\LoginService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $userService;
    protected $loginService;
    protected $categoryService;

    public function __construct(UserService $userService,LoginService $loginService,CategoryService $categoryService )
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
        $this->categoryService = $categoryService;
    }

    public function showLogin()
    {
        $categories = $this->categoryService->getAll();
        if (session()->has('user')){
            toastInfo('You are logging in');
            return redirect()->route('home');
        }
        return view('frontend.login',compact('categories'));
    }

    public function login(Request $request)
    {
        $userData = ['email' => $request->email, 'password' => $request->password];
        $success = $this->loginService->login($userData);
        if ($success){
            return redirect()->route('home');
        }else{
            return redirect()->route('showFrontendLogin')->withErrors(['email' => 'Information not correct']);
        }
    }
    public function logout(){
        session()->flush();
        return redirect()->route('home');
    }

}
