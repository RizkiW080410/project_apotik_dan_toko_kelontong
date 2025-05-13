<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Simpan user baru dengan role Pelanggan
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('Pelanggan');

        // Simpan data ke tabel pembelis
        Pembeli::create([
            'user_id' => $user->id,
            'nama_lengkap' => $validated['name'],
            'jenis_kelamin' => $validated['gender'] === 'Laki-laki' ? 'L' : 'P',
            'nomor_telpon' => $validated['phone'],
            'avatar' => null,
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->intended('/');
    }
}
