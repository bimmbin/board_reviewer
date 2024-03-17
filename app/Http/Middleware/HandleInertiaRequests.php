<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that is loaded on the first page visit.
   *
   * @var string
   */
  protected $rootView = 'app';

  /**
   * Determine the current asset version.
   */
  public function version(Request $request): string|null
  {
    return parent::version($request);
  }

  /**
   * Define the props that are shared by default.
   *
   * @return array<string, mixed>
   */
  public function share(Request $request): array
  {
    if (Auth::check()) {
      if ($request->user()->user_role == 'student') {
        $user_profile = $request->user()->student_profile;
      } else {
        $user_profile = $request->user()->staff_profile;
      }
    } else {
      //not authenticated
      $user_profile = null;
    }

    return [
      ...parent::share($request),
      'auth' => [
        'user' => $request->user(),
        'profile' => $user_profile,
      ],
      'ziggy' => fn () => [
        ...(new Ziggy)->toArray(),
        'location' => $request->url(),
      ],
      'flash' => [
        'message' => fn () => $request->session()->get('message'),
        'color' => fn () => $request->session()->get('color'),
        'is_array' => fn () => $request->session()->get('is_array'),
      ],
    ];
  }
}
