<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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

    $student = User::with('student_profile')->where('user_role', 'student')->latest()->first();
    $instructor = User::with('staff_profile')->where('user_role', 'instructor')->latest()->first();
    $dean = User::with('staff_profile')->where('user_role', 'dean')->latest()->first();
    $admin = User::where('user_role', 'admin')->latest()->first();

    return Inertia::render('Auth/Login', [
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
      'student' => $student,
      'instructor' => $instructor,
      'dean' => $dean,
      'admin' => $admin,
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
      return redirect()->route('dashboard.index');
    } else {
      return redirect()->route('main.dashboard.index');
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
