<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use Illuminate\Http\Request;

class CultureController extends Controller
{
    public function index()
    {
        return response()->json(Culture::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $culture = Culture::create($validated);
        return response()->json($culture, 201);
    }

    public function show($id)
    {
        $culture = Culture::findOrFail($id);
        return response()->json($culture);
    }

    public function update(Request $request, $id)
    {
        $culture = Culture::findOrFail($id);
        $culture->update($request->all());
        return response()->json($culture);
    }

    public function destroy($id)
    {
        $culture = Culture::findOrFail($id);
        $culture->delete();
        return response()->json(null, 204);
    }
}
