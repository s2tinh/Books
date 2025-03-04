<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class SePayService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('SEPAY_API_URL', 'https://api.sepay.vn');
        $this->apiKey = env('SEPAY_API_KEY');
    }

    public function checkTransaction($transactionId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->apiUrl}/transactions/{$transactionId}");

        return $response->json();
    }
}
