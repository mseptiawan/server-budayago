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
    $query = Culture::with('user');

    if ($request->has('category') && $request->category !== 'all') {
        $query->where('category', $request->category);
    }

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
            'image_url' => $this->fullMediaUrl($culture->image_url),
            'video_url' => $this->fullMediaUrl($culture->video_url),
            'virtual_tour_url' => $this->fullMediaUrl($culture->virtual_tour_url),
            'created_at' => $culture->created_at,
        ];
    });

    return response()->json($cultures);
}

/**
 * Menampilkan detail Budaya
 */
public function show($id)
{
    $culture = Culture::with(['user', 'favorites'])->findOrFail($id);

    $culture->image_url = $this->fullMediaUrl($culture->image_url);
    $culture->video_url = $this->fullMediaUrl($culture->video_url);
    $culture->virtual_tour_url = $this->fullMediaUrl($culture->virtual_tour_url);

    $culture->is_favorited = Auth::check()
        ? $culture->favorites()->where('user_id', Auth::id())->exists()
        : false;

    return response()->json($culture);
}

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

    // Upload file
   $validated['image_file'] = $request->file('image_file')->store('cultures/images', 'public');

if ($request->hasFile('video_file')) {
    $validated['video_file'] = $request->file('video_file')->store('cultures/videos', 'public');
}

if ($request->hasFile('virtual_tour_file')) {
    $validated['virtual_tour_file'] = $request->file('virtual_tour_file')->store('cultures/virtual', 'public');
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
public function update(Request $request, $id)
{
    $culture = Culture::findOrFail($id);

    // Cek admin
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Akses ditolak'], 403);
    }

    $categoryRules = 'string|in:' . implode(',', $this->allowedCategories);

    // Validasi input, semua optional (nullable)
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

    // Upload file jika ada
    if ($request->hasFile('image_file')) {
        $validated['image_file'] = $request->file('image_file')->store('cultures/images', 'public');
    }

    if ($request->hasFile('video_file')) {
        $validated['video_file'] = $request->file('video_file')->store('cultures/videos', 'public');
    }

    if ($request->hasFile('virtual_tour_file')) {
        $validated['virtual_tour_file'] = $request->file('virtual_tour_file')->store('cultures/virtual', 'public');
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
