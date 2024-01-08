<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
  /**
   * Display the login view.
   */
  public function create(): Response
  {
    return Inertia::render('Auth/Login', [
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
    ]);
  }

  /**
   * Handle an incoming authentication request.
   */
  public function store(LoginRequest $request)
  {

    $request->authenticate();

    $request->session()->regenerate();

    $user_role = Auth::user()->user_role;

    if ($user_role == 'student') {
      return redirect()->route('category.index');
    } elseif ($user_role == 'admin') {
      return redirect()->route('majors.index');
    } elseif ($user_role == 'instructor') {
      return redirect()->route('instructor.majors.index');
    } elseif ($user_role == 'dean') {
      return redirect()->route('dean.majors.index');
    }
  }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): RedirectResponse
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}
