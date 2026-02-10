<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class DIDService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('DID_API_KEY');
        $this->apiUrl = env('DID_API_URL');
    }

    public function generateVideo($text)
    {
        $response = $this->client->post("{$this->apiUrl}/talks", [
            'headers' => [
                'Authorization' => "Basic " . base64_encode($this->apiKey),
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                "script" => [
                    "type" => "text",
                    "input" => $text,
                    "provider" => "microsoft",
                    "voice_id" => "en-US-AriaNeural"
                ],
                "source_url" => "https://d-id.com/images/avatar-demo.jpg", // Change to your avatar image URL
                "config" => [
                    "fluent" => true,
                    "stitch" => true
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getVideoStatus($videoId)
    {
        $response = $this->client->get("{$this->apiUrl}/talks/$videoId", [
            'headers' => [
                'Authorization' => "Basic " . base64_encode($this->apiKey),
                'Content-Type'  => 'application/json'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
