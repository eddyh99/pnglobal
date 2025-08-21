<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BinancePayService
{
    private $apiUrl = 'https://bpay.binanceapi.com/binancepay/openapi/v2/';
    private $apiKey;
    private $secretKey;
    private $client;

    public function __construct()
    {
        $this->apiKey = getenv('BINANCE_PAY_API_KEY');
        $this->secretKey = getenv('BINANCE_PAY_SECRET_KEY');
        $this->client = new Client();
    }

    private function getHeaders($payload) {
        $timestamp = round(microtime(true) * 1000);
        $nonce = bin2hex(random_bytes(16));
        $jsonPayload = is_array($payload) ? json_encode($payload) : $payload;
        $signature = strtoupper(hash_hmac('sha512', "$timestamp\n$nonce\n$jsonPayload\n", $this->secretKey));


        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'BinancePay-Timestamp' => $timestamp,
                'BinancePay-Nonce' => $nonce,
                'BinancePay-Signature' => $signature,
                'BinancePay-Certificate-SN' => $this->apiKey,
            ],
            'body' => $payload
        ];
    }

    public function checkBalance()
    {
        $url = $this->apiUrl . 'balance';
        $payload = '{}';
        $headers = $this->getHeaders($payload);

        try {
            $response = $this->client->post($url, $headers);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }


    public function createPayment($amount, $currency, $orderId, $customerEmail)
    {
        $url = $this->apiUrl . 'order';
        $payload = [
            'env' => ['terminalType' => 'WEB'],
            'merchantTradeNo' => $orderId,
            'orderAmount' => (float)$amount,
            'currency' => strtoupper($currency),
            'goods' => [
                'goodsType' => '02',
                'goodsCategory' => '80000000',
                'referenceGoodsId' => '123456',
                'goodsName' => 'USDT Payment',
                'goodsDetail' => 'USDT payment for services'
            ],
            'buyer' => [
                'buyerEmail' => $customerEmail
            ]
        ];

        $headers = $this->getHeaders($payload);

        try {
            $response = $this->client->post($url, $headers);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
