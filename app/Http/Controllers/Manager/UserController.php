<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        $status = $request->get('status');

        $query = User::where('role', '!=', 'manager');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($status !== null) {
            $query->where('is_active', $status == 'active' ? 1 : 0);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        $stats = [
            'total' => User::where('role', '!=', 'manager')->count(),
            'active' => User::where('role', '!=', 'manager')->where('is_active', true)->count(),
            'inactive' => User::where('role', '!=', 'manager')->where('is_active', false)->count(),
            'gudang' => User::where('role', 'gudang')->count(),
            'member' => User::where('role', 'member')->count(),
        ];

        return view('manager.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:gudang,member',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('manager.users.index')
                        ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Pastikan hanya user dengan role gudang atau member yang bisa dilihat
        if ($user->role === 'manager') {
            abort(403, 'Unauthorized action.');
        }

        return view('manager.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Pastikan hanya user dengan role gudang atau member yang bisa diedit
        if ($user->role === 'manager') {
            abort(403, 'Unauthorized action.');
        }

        return view('manager.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Pastikan hanya user dengan role gudang atau member yang bisa diupdate
        if ($user->role === 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:gudang,member',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('manager.users.index')
                        ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Pastikan hanya user dengan role gudang atau member yang bisa diubah statusnya
        if ($user->role === 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "User {$user->name} berhasil {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Pastikan hanya user dengan role gudang atau member yang bisa dihapus
        if ($user->role === 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('manager.users.index')
                        ->with('success', 'User berhasil dihapus.');
    }
}
