<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact("users"));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'password' => 'required|string|',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid. Harus ada "@" dan domain.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Role wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:Admin,Employee',
            'password' => 'nullable|',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid. Harus ada "@" dan domain.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Role wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $User)
    {
        $User->delete();
        return redirect()->route('users.index')->with('success', 'User dihapus');
    }
}
