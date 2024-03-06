<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\CssSelector\Node\FunctionNode;

class DashboardController extends Controller
{
  public function index() {
    return Inertia::render('Student/Dashboard');
  }
}
