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
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        // ambil data level_kode dari user yg login
        $user_role = $request->user()->getRole();   
        
        if(in_array($user_role, $roles)) { // cek apa level_kode user ada di dlm array roles
            return $next($request);
        }

        //jika tdk punya role
        abort(403, 'Tidak memiliki akses ke halaman ini');
    }
}
