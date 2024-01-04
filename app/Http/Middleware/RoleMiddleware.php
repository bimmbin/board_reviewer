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
  public function handle(Request $request, Closure $next, String $role): Response
  {
    $user_role = Auth::user()->user_role;

    if (Auth::check() && $user_role !== $role) {
      return redirect()->route('unauthorized');
    }
    return $next($request);
  }
}
