<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // dd($role);
        $user = Auth::user();
        
        if ($user && $user->role === $role) {
            return $next($request);
        } else if ($user->role === 'admin'){
            return redirect()->route('admin.index');
        } else if ($user->role === 'kasir'){
            return redirect()->route('cashier.index');
        } else {
            return redirect()->route('member.index');
        }
        

        // return redirect()->route('auth.index')->with('error', 'Access Denied');
    }
}
