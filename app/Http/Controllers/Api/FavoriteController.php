<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        // Semua fungsi di controller ini harus membutuhkan autentikasi
        $this->middleware('auth:sanctum');
    }

    /**
     * Menampilkan daftar semua budaya yang difavoritkan oleh user yang sedang login.
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
                              ->with(['culture' => function ($query) {
                                  // Memuat data culture yang dibutuhkan untuk tampilan list
                                  $query->select('id', 'title', 'province', 'city_or_regency', 'short_description', 'image_url');
                              }])
                              ->get();
        
        // Mengubah format output agar lebih mudah dikonsumsi di frontend
        return response()->json($favorites->map(function ($favorite) {
            return $favorite->culture;
        }));
    }

    /**
     * Menambah Culture ke daftar favorit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'culture_id' => 'required|exists:cultures,id',
        ]);

        $cultureId = $validated['culture_id'];
        $userId = Auth::id();

        // Mencegah duplikasi entri favorit
        $favorite = Favorite::where('user_id', $userId)
                             ->where('culture_id', $cultureId)
                             ->first();

        if ($favorite) {
            return response()->json([
                'message' => 'Budaya sudah ada di daftar favorit.'
            ], 409); // 409 Conflict
        }

        // Buat entri favorit baru
        Favorite::create([
            'user_id' => $userId,
            'culture_id' => $cultureId,
        ]);

        return response()->json([
            'message' => 'Budaya berhasil ditambahkan ke favorit.'
        ], 201);
    }

    /**
     * Menghapus Culture dari daftar favorit (Unfavorite).
     * Menggunakan culture_id sebagai parameter karena relasi unik adalah user_id + culture_id.
     */
    public function destroy($cultureId)
    {
        $userId = Auth::id();

        $deletedCount = Favorite::where('user_id', $userId)
                                 ->where('culture_id', $cultureId)
                                 ->delete();

        if ($deletedCount === 0) {
            return response()->json([
                'message' => 'Budaya tidak ditemukan di daftar favorit Anda.'
            ], 404);
        }

        return response()->json([
            'message' => 'Budaya berhasil dihapus dari favorit.'
        ], 200);
    }
}