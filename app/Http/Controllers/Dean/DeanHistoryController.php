<?php

namespace App\Http\Controllers\Dean;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeanHistory;

class DeanHistoryController extends Controller
{
  public function index()
  {
    $histories = DeanHistory::getDeanHistory();
      
    return Inertia::render('Dean/DeanHistory', [
      'histories' => $histories,
    ]);
  }
}
