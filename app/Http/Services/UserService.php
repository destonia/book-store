<?php


namespace App\Http\Services;


use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Repositories\UserRepo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserService
{
    protected $userRepo;
    protected $emailController;
    protected $loginService;
    public function __construct(
        UserRepo $userRepo,
        EmailController $emailController,
        LoginService $loginService
    )
    {
        $this->userRepo = $userRepo;
        $this->emailController = $emailController;
        $this->loginService = $loginService;
    }
    public function store($request){
        DB::beginTransaction();
        try {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $role_id = [3];
            $this->userRepo->store($user);
            $user->roles()->sync($role_id);
            DB::commit();
            $this->emailController->sendEmail($user);
            $userData = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            $this->loginService->login($userData);
        }catch (\Exception $exception ){
            DB::rollBack();
            dd($user,$exception);
        }
    }
}
