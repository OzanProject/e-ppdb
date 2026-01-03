<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::query();

        // Filter by Role
        if (request()->has('role') && request('role') != '') {
            $query->where('role', request('role'));
        }

        // Order: ID 1 (Administrator) first, then newest created users
        $users = $query->orderByRaw('CASE WHEN id = 1 THEN 1 ELSE 0 END DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(15); // Use pagination for better performance

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'     => ['required', 'in:admin,panitia,siswa'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],
            'password'  => Hash::make($validated['password']),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', 'in:admin,panitia,siswa'],
        ]);

        $user->name      = $validated['name'];
        $user->email     = $validated['email'];
        $user->role      = $validated['role'];
        $user->is_active = $request->has('is_active');
        
        // Password update is handled separately/optionally in edit view or separate method if desired
        // But for simplicity, let's allow password update here if filled
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:8'],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === 1 || $user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun ini.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // Prevent deleting ID 1 (Administrator) or current user
        if (in_array(1, $ids) || in_array(auth()->id(), $ids)) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Administrator Utama atau akun Anda sendiri.');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->route('admin.users.index')->with('success', count($ids) . ' user berhasil dihapus.');
    }
}
