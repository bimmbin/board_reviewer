<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user_role = Auth::user()->user_role;

    if (Auth::check() && $user_role !== 'student') {

      //redirect them to their own authenticated landing page (add if there are more users)
      if ($user_role == 'admin') {
        return redirect()->route('majors.index');
      }
    }
    return $next($request);
  }
}
