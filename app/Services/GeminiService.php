<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY'); 
        
        // Cek jika API Key kosong (untuk menghindari error sebelum request)
        if (empty($this->apiKey)) {
            throw new \Exception("GEMINI_API_KEY is not set in the environment.");
        }
    }

    /**
     * Kirim pertanyaan ke Gemini AI dan ambil jawaban.
     */
    public function askGemini(string $prompt): string
    {
        // Gunakan v1beta untuk generateContent
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

        // Kirim request TANPA header Authorization. API Key harus di URL.
        $response = Http::post($url . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            // PERBAIKAN: Pindahkan konfigurasi ke 'generationConfig'
            'generationConfig' => [ 
                'temperature' => 0.7,
                'candidate_count' => 1
                // Anda juga bisa menambahkan 'maxOutputTokens' di sini jika perlu
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Berikan detail body error jika status bukan 401/400
            return "Maaf, terjadi kesalahan saat menghubungi Gemini AI: " . $response->status();
        }

        $data = $response->json();

        // Cek jika ada 'candidates' dan 'parts' sebelum mengambil teks
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $data['candidates'][0]['content']['parts'][0]['text'];
        }

        // Jika tidak ada kandidat, mungkin diblokir (prompt safety)
        if (isset($data['promptFeedback']['safetyRatings'])) {
             return "Maaf, pertanyaan Anda melanggar kebijakan keamanan AI.";
        }

        return 'Tidak ada jawaban spesifik dari Gemini.';
    }
}