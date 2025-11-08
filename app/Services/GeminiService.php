<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY'); // pastikan di .env ada GEMINI_API_KEY
    }

    /**
     * Kirim pertanyaan ke Gemini AI dan ambil jawaban.
     */
    public function askGemini(string $prompt): string
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta2/models/gemini-1.5:generateMessage';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'prompt' => [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ]
                ]
            ],
            'temperature' => 0.7,
            'candidate_count' => 1
        ]);

        if ($response->failed()) {
            return "Maaf, terjadi kesalahan saat menghubungi Gemini AI: " . $response->body();
        }

        $data = $response->json();

        // Ambil jawaban dari response Gemini
        return $data['candidates'][0]['content'] ?? 'Tidak ada jawaban dari Gemini.';
    }
}
