<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeminiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com/v1beta/',
            'timeout'  => 30.0,
        ]);
    }

    public function askGemini(string $prompt): string
    {
        $model = 'gemini-1.5-flash'; // atau gemini-pro
        $url = "models/{$model}:generateContent?key={$this->apiKey}";

        $response = $this->client->post($url, [
            'json' => [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respon dari Gemini.';
    }
}
