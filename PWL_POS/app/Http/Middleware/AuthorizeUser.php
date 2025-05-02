<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = ''): Response
    {
        // ambil data user yg login
        $user = $request->user();   // user() diambil dari UserModel.php
        
        if($user->hasRole($role)) {
            return $next($request);
        }

        //jika tdk punya role
        abort(403, 'Tidak memiliki akses ke halaman ini');
    }
}
