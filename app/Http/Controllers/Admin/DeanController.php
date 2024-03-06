<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class DeanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $instructors = StaffProfile::whereHas('user', function (Builder $query) {
        $query->where('user_role', 'dean');
      })->with('user')->when($request->input('search'), function ($query, $search) {
        $query->where('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('middle_name', 'like', "%{$search}%")
          ->orWhere('employee_number', 'like', "%{$search}%");
      })->latest()
        ->paginate(10)
        ->withQueryString()
        ->through(function ($item) {
          return [
            'id' => $item->id,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'middle_name' => $item->middle_name,
            'employee_number' => $item->employee_number,
            'user_id' => $item->user->id,
          ];
        });

      $dean_count = User::where('user_role', 'dean')->count();
  
      return Inertia::render('Admin/Dean', [
        'instructors' => $instructors,
        'dean_count' => $dean_count,
      ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'employee_number' => 'required|integer|unique:' . StaffProfile::class,
        'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
        'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
        'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      ]);
  
      $dean = User::create([
        'username' => $request->last_name . $request->employee_number,
        'user_role' => 'dean',
        'password' => Hash::make($request->employee_number),
      ]);
  
      StaffProfile::create([
        'user_id' => $dean->id,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'middle_name' => $request->middle_name,
        'employee_number' => $request->employee_number,
      ]);
  
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $request->validate([
        'employee_number' => ['required', Rule::unique('staff_profiles')->ignore($id)],
        'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
        'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
        'middle_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
      ]);
  
      $staff_user = User::findOrFail($request->user_id);
      $staff_user->username = $request->last_name.$request->employee_number;
      $staff_user->save();
  
      //restore password status if it is already added
  
      $staff_profile = StaffProfile::findOrFail($id);
      $staff_profile->first_name = $request->first_name;
      $staff_profile->last_name = $request->last_name;
      $staff_profile->middle_name = $request->middle_name;
      $staff_profile->employee_number = $request->employee_number;
      $staff_profile->save();
  
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
