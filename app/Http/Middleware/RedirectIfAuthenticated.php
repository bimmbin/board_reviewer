<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, string ...$guards): Response
  {
    $guards = empty($guards) ? [null] : $guards;

    //if user is logged in
    if (Auth::check()) {
      $user_role = Auth::user()->user_role;
      foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
          
          //redirect them to their own authenticated landing page
          if ($user_role == 'admin') {
            return redirect()->route('majors.index');
          }
          if ($user_role == 'student') {
            return redirect()->route('category.index');
          }
        }
      }
    }

    return $next($request);
  }
}
