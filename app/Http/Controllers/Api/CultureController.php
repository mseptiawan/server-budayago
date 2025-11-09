<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CultureController extends Controller
{
    // Kategori yang diizinkan sesuai rencana
    protected $allowedCategories = [
        'Tarian', 'Kuliner', 'Busana Adat', 'Kriya', 
        'Upacara Adat', 'Arsitektur', 'Seni Tradisional'
    ];

  
    /**
     * Menampilkan daftar semua Budaya (List Budaya).
     * Dapat digunakan oleh semua User.
     */
    public function index(Request $request)
    {
        // Inisialisasi query dasar
        $query = Culture::with('user'); // Load relasi dengan User (Admin)

        // Logika Filtering:
        // Filter berdasarkan Kategori
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan Provinsi
        if ($request->has('province') && $request->province !== 'all') {
            $query->where('province', $request->province);
        }

        // Ambil data untuk List Budaya (deskripsi singkat)
        $cultures = $query->select([
            'id', 'title', 'category', 'province', 'city_or_regency', 
            'short_description', 'image_url', 'created_at'
        ])->get();

        return response()->json($cultures);
    }

    /**
     * Menyimpan Budaya baru (Hanya Admin).
     */
    public function store(Request $request)
    {
        // Menggunakan array untuk validasi kategori
        $categoryRules = 'required|string|in:' . implode(',', $this->allowedCategories);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => $categoryRules,
            'province' => 'required|string|max:100',
            'city_or_regency' => 'required|string|max:100',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'image_url' => 'required|url|max:255', // Asumsi URL (untuk storage terpisah)
            'video_url' => 'nullable|url|max:255',
            'virtual_tour_url' => 'nullable|url|max:255',
        ]);

        // Tambahkan ID Admin yang memposting
        $validated['user_id'] = Auth::id();

        $culture = Culture::create($validated);
        return response()->json([
            'message' => 'Budaya berhasil ditambahkan.',
            'data' => $culture
        ], 201);
    }

    /**
     * Menampilkan detail Budaya lengkap.
     * Dapat digunakan oleh semua User.
     */
    public function show($id)
    {
        $culture = Culture::with(['user', 'favorites'])->findOrFail($id);
        
        // Cek apakah user saat ini telah memfavoritkan item ini
        $culture->is_favorited = Auth::check() 
                                ? $culture->favorites()->where('user_id', Auth::id())->exists() 
                                : false;

        return response()->json($culture);
    }

    /**
     * Memperbarui Budaya yang ada (Hanya Admin).
     */
    public function update(Request $request, $id)
    {
        $culture = Culture::findOrFail($id);
        
        // Memastikan hanya admin yang bisa melakukan update (sudah ada di constructor, tapi untuk keamanan)
        if (Auth::user()->role !== 'admin') {
             return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // Menggunakan array untuk validasi kategori
        $categoryRules = 'required|string|in:' . implode(',', $this->allowedCategories);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|' . $categoryRules,
            'province' => 'sometimes|required|string|max:100',
            'city_or_regency' => 'sometimes|required|string|max:100',
            'short_description' => 'sometimes|required|string|max:500',
            'long_description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'virtual_tour_url' => 'nullable|url|max:255',
        ]);

        $culture->update($validated);
        return response()->json([
            'message' => 'Budaya berhasil diperbarui.',
            'data' => $culture
        ]);
    }

    /**
     * Menghapus Budaya (Hanya Admin).
     */
    public function destroy($id)
    {
        $culture = Culture::findOrFail($id);
        
        // Memastikan hanya admin yang bisa melakukan destroy
        if (Auth::user()->role !== 'admin') {
             return response()->json(['message' => 'Akses ditolak.'], 403);
        }
        
        $culture->delete();
        return response()->json(null, 204);
    }
}