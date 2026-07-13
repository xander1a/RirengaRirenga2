<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::role(['director', 'manager', 'staff'])->with('roles')->get();
        $roles = Role::whereIn('name', ['manager', 'staff'])->get();
        return view('admin.staff.index', compact('staff', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:30',
            'role'     => 'required|in:manager,staff',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['role']);

        return redirect()->back()->with('success', 'Staff member created.');
    }

    public function destroy(User $user)
    {
        abort_if($user->hasRole('director'), 403, 'Cannot delete a director.');
        $user->delete();
        return redirect()->back()->with('success', 'Staff member removed.');
    }
}
