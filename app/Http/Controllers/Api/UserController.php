<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        return User::all(); // Mendapatkan semua user
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // 'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201);
    }


    public function show($id)
    {
        return User::findOrFail($id); // Mendapatkan detail user berdasarkan ID
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
        ]);

        $user->update($validatedData); // Mengupdate user
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Menghapus user
        return response(null, 204); // Tidak ada konten
    }
}
