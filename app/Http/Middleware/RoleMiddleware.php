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
  public function handle(Request $request, Closure $next, ...$role): Response
  {
    if (!Auth::check()) {
      // User is not authenticated, redirect them to the login page
      return redirect()->route('login');
    }

    $user_role = Auth::user()->user_role;


    foreach ($role as $chosen_role) {
      if ($user_role === $chosen_role) {
        return $next($request);
      }
    }

    return redirect()->route('unauthorized');
  }
}
