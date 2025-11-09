<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register user baru (otomatis sebagai 'user')
     */
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default role
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user
        ], 201);
    }

    /**
     * Login user dan buat token Sanctum
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Hapus token lama agar tidak menumpuk
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Logout user (hapus token aktif)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }
 public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil user yang login

        // Validasi input
        $validated = $request->validate([
            'fullname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        ]);

        // Update user
        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }


      public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 400);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'message' => 'Password berhasil diperbarui'
        ]);
    }
    public function getProfile()
{
    $user = Auth::user(); // Ambil user yang login

    return response()->json([
        'id' => $user->id,
        'fullname' => $user->fullname,
        'email' => $user->email,
        'role' => $user->role,
        'created_at' => $user->created_at,
        'updated_at' => $user->updated_at,
    ]);
}

}
