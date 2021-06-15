<?php


namespace App\Http\Repositories;


class UserRepo
{
    public function store($user)
    {
        $user->save();
    }
}
