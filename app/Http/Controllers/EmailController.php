<?php

namespace App\Http\Controllers;

use App\Mail\SignupEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail($user)
    {
        $data = [
            'name' => $user->name,
            'verifyCode' => 1234];
        Mail::to('lanhthanh.dktd@gmail.com')->send(new SignupEmail($data));
    }

}
