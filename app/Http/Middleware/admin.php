<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user')) {
            $isAdmin = 0;
            $userEmail = session()->get('user')[0]['email'];
            $user = User::where('email', '=', $userEmail)->get();
            $userRoles = $user[0]->roles;
            foreach ($userRoles as $role) {
                if ($role->id == 1) {
                    $isAdmin = 1;
                }
            }
            if ($isAdmin == 1) {
                return $next($request);
            } else {
                session()->forget('user');
                return view('backend.permission');
            }
        }
        return redirect()->route('showLogin');
    }
}
