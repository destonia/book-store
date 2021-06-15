<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Services\CategoryService;
use App\Http\Services\LoginService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userService;
    protected $loginService;
    protected $categoryService;
    public function __construct(UserService $userService, LoginService $loginService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
        $this->categoryService = $categoryService;
    }
    public function showRegister(){
        $categories = $this->categoryService->getAll();
        return view('frontend.register',compact('categories'));
    }
    public function register(RegisterRequest $request){
        $this->userService->store($request);
        return redirect()->route('home');
    }
}
