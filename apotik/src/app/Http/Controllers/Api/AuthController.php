<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
            'nama_lengkap'   => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'min:6'],
            'nomor_telepon'  => ['required', 'string', 'max:20'],
            'tanggal_lahir'  => ['nullable', 'date'],
            'jenis_kelamin'  => ['nullable', Rule::in(array_keys(Profile::JENIS_KELAMIN_SELECT))],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'fail',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->nama_lengkap,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tambahkan role dengan title 'User'
        $roleUser = \App\Models\Role::where('title', 'User')->first();
        if ($roleUser) {
            $user->roles()->attach($roleUser->id);
        }

        // Buat profile
        $user->profile()->create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->load('profile'); // Include profile

            return response()->json([
                'status'  => 'success',
                'message' => 'Login berhasil',
                'user'    => $user
            ]);
        }

        return response()->json([
            'status'  => 'fail',
            'message' => 'Email atau password salah'
        ], 401);
    }
}
