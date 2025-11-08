<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatbotController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        $prompt = "Kamu adalah asisten budaya Indonesia. Jawab pertanyaan berikut secara informatif dan akurat:\n\n" . $userMessage;

        $answer = $this->gemini->askGemini($prompt);

        return response()->json([
            'question' => $userMessage,
            'answer' => $answer,
        ]);
    }
}
