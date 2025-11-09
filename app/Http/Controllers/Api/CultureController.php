<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CultureController extends Controller
{
protected $allowedCategories = [
    'Tarian', 'Kuliner', 'Busana Adat', 'Kriya',
    'Upacara Adat', 'Arsitektur', 'Seni Tradisional'
];

/**
 * Helper untuk generate URL lengkap dari file storage
 */
protected function fullMediaUrl($path)
{
    return $path ? Storage::disk('public')->url($path) : null;
}

/**
 * Menampilkan daftar semua Budaya
 */
public function index(Request $request)
{
    // Inisialisasi query dasar
    $query = Culture::with('user');

    // Filter berdasarkan Kategori
    if ($request->has('category') && $request->category !== 'all') {
        $query->where('category', $request->category);
    }

    // Filter berdasarkan Provinsi (Untuk fitur Peta)
    if ($request->has('province') && $request->province !== 'all') {
        $query->where('province', $request->province);
    }

    $cultures = $query->get()->map(function ($culture) {
        return [
            'id' => $culture->id,
            'title' => $culture->title,
            'category' => $culture->category,
            'province' => $culture->province,
            'city_or_regency' => $culture->city_or_regency,
            'short_description' => $culture->short_description,
            
            // --- PENYESUAIAN PENTING DI SINI ---
            // Gunakan FIELD DB ('..._file') sebagai input untuk helper:
            'image_url' => $this->fullMediaUrl($culture->image_file),       // Mengambil dari kolom image_file
            'video_url' => $this->fullMediaUrl($culture->video_file),       // Mengambil dari kolom video_file
            'virtual_tour_url' => $this->fullMediaUrl($culture->virtual_tour_file), // Mengambil dari kolom virtual_tour_file
            
            // --- AKHIR PENYESUAIAN ---
            
            'created_at' => $culture->created_at,
        ];
    });

    return response()->json($cultures);
}

/**
 * Menampilkan detail Budaya
 */
/**
 * Menampilkan detail Budaya
 */
public function show($id)
{
    // Cari budaya beserta relasi user dan favorites
    $culture = Culture::with(['user', 'favorites'])->findOrFail($id);

    // --- PENYESUAIAN PENTING DI SINI ---
    // 1. Menggunakan FIELD DB ('..._file') untuk mengambil path.
    // 2. Menimpa properti sementara ('..._url') di objek $culture untuk respons JSON.
    
    // Konversi path file (dari kolom DB: ..._file) menjadi full URL
    $culture->image_url = $this->fullMediaUrl($culture->image_file);
    $culture->video_url = $this->fullMediaUrl($culture->video_file);
    $culture->virtual_tour_url = $this->fullMediaUrl($culture->virtual_tour_file);
    
    // --- AKHIR PENYESUAIAN ---

    // Menentukan apakah user saat ini sudah memfavoritkan (untuk tampilan di frontend)
    $culture->is_favorited = Auth::check()
        ? $culture->favorites()->where('user_id', Auth::id())->exists()
        : false;

    // Mengembalikan objek budaya (dengan is_favorited dan URL media lengkap)
    return response()->json($culture);
}
/**
 * Menambahkan Budaya baru (Admin)
 */
/**
 * Menambahkan Budaya baru (Admin)
 */
public function store(Request $request)
{
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Akses ditolak'], 403);
    }

    $categoryRules = 'required|string|in:' . implode(',', $this->allowedCategories);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category' => $categoryRules,
        'province' => 'required|string|max:100',
        'city_or_regency' => 'required|string|max:100',
        'short_description' => 'required|string|max:500',
        'long_description' => 'required|string',
        'image_file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
        'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:20480', // 20 MB
        'virtual_tour_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4|max:20480', // 20 MB
    ]);

    // UPLOAD FILE DAN GANTI NILAI KEY DENGAN STRING PATH
    $validated['image_file'] = $request->file('image_file')->store('cultures/images', 'public');

    if ($request->hasFile('video_file')) {
        $validated['video_file'] = $request->file('video_file')->store('cultures/videos', 'public');
    } else {
        // Hapus key jika tidak ada file video yang di-upload
        unset($validated['video_file']); 
    }

    if ($request->hasFile('virtual_tour_file')) {
        $validated['virtual_tour_file'] = $request->file('virtual_tour_file')->store('cultures/virtual', 'public');
    } else {
        // Hapus key jika tidak ada file virtual tour yang di-upload
        unset($validated['virtual_tour_file']); 
    }

    $validated['user_id'] = Auth::id();

    $culture = Culture::create($validated);

    // Kembalikan URL lengkap untuk frontend
    $culture->image_url = $this->fullMediaUrl($culture->image_file);
    $culture->video_url = $this->fullMediaUrl($culture->video_file);
    $culture->virtual_tour_url = $this->fullMediaUrl($culture->virtual_tour_file);

    return response()->json([
        'message' => 'Budaya berhasil ditambahkan',
        'data' => $culture
    ], 201);
}

/**
 * Update Budaya (Admin)
 */
/**
 * Update Budaya (Admin)
 */
public function update(Request $request, $id)
{
    $culture = Culture::findOrFail($id);

    // Cek admin
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Akses ditolak'], 403);
    }

    $categoryRules = 'string|in:' . implode(',', $this->allowedCategories);

    // Validasi input menggunakan 'sometimes'
    $validated = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'category' => 'sometimes|' . $categoryRules,
        'province' => 'sometimes|required|string|max:100',
        'city_or_regency' => 'sometimes|required|string|max:100',
        'short_description' => 'sometimes|required|string|max:500',
        'long_description' => 'sometimes|required|string',
        'image_file' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
        'video_file' => 'sometimes|file|mimes:mp4,mov,avi|max:20480',
        'virtual_tour_file' => 'sometimes|file|mimes:jpg,jpeg,png,gif,mp4|max:20480',
    ]);

    // UPLOAD DAN REPLACE KEY DENGAN STRING PATH
    if ($request->hasFile('image_file')) {
        $validated['image_file'] = $request->file('image_file')->store('cultures/images', 'public');
    } else {
        // HAPUS KEY jika file tidak di-upload. Ini penting agar path lama tetap ada.
        unset($validated['image_file']);
    }

    if ($request->hasFile('video_file')) {
        $validated['video_file'] = $request->file('video_file')->store('cultures/videos', 'public');
    } else {
        unset($validated['video_file']);
    }

    if ($request->hasFile('virtual_tour_file')) {
        $validated['virtual_tour_file'] = $request->file('virtual_tour_file')->store('cultures/virtual', 'public');
    } else {
        unset($validated['virtual_tour_file']);
    }

    // Update database hanya field yang ada di $validated
    $culture->update($validated);

    // Set URL lengkap untuk frontend
    $culture->image_url = $this->fullMediaUrl($culture->image_file);
    $culture->video_url = $this->fullMediaUrl($culture->video_file);
    $culture->virtual_tour_url = $this->fullMediaUrl($culture->virtual_tour_file);

    return response()->json([
        'message' => 'Budaya berhasil diperbarui',
        'data' => $culture
    ]);
}
// public function update(Request $request, $id)
// {
//     // Debug cepat: cek apa yang dikirim
//     \Log::info('Update request:', $request->all());
//     \Log::info('Files:', $request->allFiles());

//     dd($request->all(), $request->allFiles());
// }


/**
 * Delete Budaya (Admin)
 */
public function destroy($id)
{
    $culture = Culture::findOrFail($id);

    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Akses ditolak'], 403);
    }

    $culture->delete();

    return response()->json([
        'message' => 'Budaya berhasil dihapus'
    ], 200);
}

}
