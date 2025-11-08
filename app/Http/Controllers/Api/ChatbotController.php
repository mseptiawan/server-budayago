<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatbotController extends Controller
{
    public function chat(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        // Kamu bisa tambahkan konteks agar Gemini tahu topiknya
        $prompt = "Kamu adalah asisten budaya Indonesia. Jawab pertanyaan berikut secara informatif dan akurat:\n\n" . $userMessage;

        $answer = $gemini->askGemini($prompt);

        return response()->json([
            'question' => $userMessage,
            'answer' => $answer,
        ]);
    }
}
