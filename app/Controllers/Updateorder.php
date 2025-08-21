<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\V1\Order;
use CodeIgniter\API\ResponseTrait;

class Updateorder extends BaseController
{
    use ResponseTrait;
    protected $order;
    protected $apiKey="FhBPTMD1kgw5kIRA8O9b73Kq0yWbBdnpedMp44hBMZ3BSK1j7HxFi581CoollpaD";
    protected $apiSecret="VyBaQTK7QsFJY9l3NR9Mq4Onu9RXABfZVZ9xmFawKfG05k3lqq6aP6b66rHZLoSV";
    protected $baseUrl = 'https://api.binance.com';
 

    public function __construct()
    {
        // apakah memungkinkan buy dan sell bersamaan pending.
        $this->signal  = model('App\Models\V1\Mdl_signal');
        $this->order = new Order();
    }

    public function postIndex()
    {
        // $mdata = [];
        // $buy = $this->signal->get_buy_order_pending();

        // if (@$buy->code != 200) {
        //     log_message('info', 'BUY ORDER: ' . json_encode($buy));
        //     if ($buy->code == 500) {
        //         return $this->respond(error_msg(500, "signal", '01', $buy->message), 500);
        //     }
        //     $buy = null;
        // }

        // $sell = $this->signal->get_sell_order_pending();

        // if (@$sell->code != 200) {
        //     log_message('info', 'SELL ORDER: ' . json_encode($sell));
        //     if ($sell->code == 500) {
        //         return $this->respond(error_msg(500, "signal", '01', $sell->message), 500);
        //     }
        //     $sell = null;
        // }

        $validation = $this->validation;
        $validation->setRules([
            'type' => [
                'rules'  => 'required|in_list[Buy A,Buy B,Buy C,Buy D]',
                'errors' => [
                    'required' => 'Type is required',
                    'in_list'  => 'Invalid type, allowed types: BUY A, BUY B, BUY C, BUY D'
                ]
            ],
            'id_signal' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required'     => 'Id Signal is required',
                    'integer'      => 'Id Signal must be an integer',
                ]
            ],
            'latsorder_ids' => [
                'rules'  => 'required|is_array',
                'errors' => [
                    'required'     => 'ID is required',
                    'is_array'      => 'ID must be an array',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $data    = $this->request->getJSON();
        $buy = $this->signal->get_buy_order_pending($data->id_signal);
        $proxies = $this->order->get_proxies();

        if (!$proxies) {
            return $this->respond(error_msg(400, "proxy", '01', 'Failed to get proxy'), 400);
        }

        if (empty($buy)) {
            return $this->respond(error_msg(200, "buys", null, 'No buy orders found!'), 200);
        }

        // update buy untuk memperbarui jumlah btc
        $mdata = $this->updateBuy($data, $buy->message, $proxies);

        if (!$mdata) {
            return $this->respond(error_msg(400, "buys", null, 'Failed!'), 400);
        }

        $result = $this->signal->update_status_order($mdata);


        if (@$result->code != 201) {
            return $this->respond(error_msg($result->code, "buy", "01", $result->message), $result->code);
        }

        return $this->respond(error_msg(201, "buys", null, 'Order has been filled'), 201);
    }
    
    private function getAssets(){
        $timestamp = round(microtime(true) * 1000);
        $queryString = "timestamp={$timestamp}";
        $signature = hash_hmac('sha256', $queryString, $this->apiSecret);

        $url = $this->baseUrl."/sapi/v1/capital/config/getall?{$queryString}&signature={$signature}";

        $client = \Config\Services::curlrequest();
        $response = $client->get($url, [
            'headers' => [
                'X-MBX-APIKEY' => $this->apiKey
            ],
            'http_errors' => false
        ]);

        return json_decode($response->getBody(), true);
    }
    
    public function getOpenorders($symbol = null)
    {
        $timestamp = round(microtime(true) * 1000);
        $query = "timestamp={$timestamp}";
        if ($symbol) {
            $query = "symbol={$symbol}&" . $query;
        }
    
        $signature = hash_hmac('sha256', $query, $this->apiSecret);
        $url = "{$this->baseUrl}/api/v3/openOrders?{$query}&signature={$signature}";
    
        $client = \Config\Services::curlrequest();
        $response = $client->get($url, [
            'headers' => [
                'X-MBX-APIKEY' => $this->apiKey
            ],
            'http_errors' => false
        ]);
    
        print_r(json_decode($response->getBody(), true));
    }


    public function getBtcbalance()
    {
        $assets = $this->getAssets();
        foreach ($assets as $asset) {
            if ($asset['coin'] == 'BTC') {
                print_r($asset);
            }
        }
        return null;
    }

    private function updateBuy($data, $signal, $proxies)
    {
        $stepSize = 0.00001000;
        foreach ($signal as $buy) {
            $proxy_key = array_rand($proxies);
            $proxy = (array) $proxies[$proxy_key];

            $mdata[] = [
                'member' => [
                    'id_member' => $buy->member_id,
                    'api_key' => $buy->api_key,
                    'api_secret' => $buy->api_secret,
                    ...$proxy
                ],
                'order' => [
                    "symbol" => "BTCUSDT",
                    "orderId" => $buy->order_id
                ]
            ];
        }

        $response = check_status_order($mdata);
        $order = new Order;
        // $amount_last_orders = $this->order->getAmount_last_order($type);
        
        if($data->type != 'Buy A') {
            $amount_last_orders = $this->signal->get_amountBTC_last_order($data->latsorder_ids);
            log_message('info', 'Amount: ' . json_encode($amount_last_orders));
    
            if ($amount_last_orders->code != 200) {
                return false;
            }
    
            $amount_last_order_map = array_column($amount_last_orders->message, 'total_amount_btc', 'member_id');
            log_message('info', 'BINANCE ORDER STATUS: ' . json_encode($response));
        }

        $balances = check_balances($mdata);
        unset($mdata);
        $is_filled = false;

        // maybe bug
        foreach ($response as $order) {
            if ($order["status"] == "FILLED") {
                $is_filled = true; // Tandai sebagai "FILLED"
                break; // Hentikan iterasi setelah menemukan satu
            }
        }

        if (!$is_filled) {
            return $this->respond(error_msg(200, "buy", null, 'order may be is pending!'), 200);
        }

        $mdata = [];
        foreach ($response as $order) {
            $member_id = $order["member_id"];
            $balance = $balances[$member_id]['btc'];

            if ($data->type !== 'Buy A') {
                $amount_btc = ($balance - $amount_last_order_map[$member_id]);
                // $balance = $order['origQty'];
            } else {
                $amount_btc = $order['origQty'];
            }

            $steps = floor((string)($amount_btc / $stepSize));
            $mdata['orders'][] = [
                'order_id' => $order["orderId"],
                'amount_btc' => bcdiv($steps * $stepSize, '1', 6)
            ];

            $mdata['order_ids'][] = $order["orderId"]; // Simpan sebagai array
        }

        return $mdata;
    }

    // private function updateSell($signal, $proxies)
    // {
    //     foreach ($signal as $sell) {
    //         $proxy_key = array_rand($proxies);
    //         $proxy = (array) $proxies[$proxy_key];

    //         $mdata[] = [
    //             'member' => [
    //                 'id_member' => $sell->member_id,
    //                 'api_key' => $sell->api_key,
    //                 'api_secret' => $sell->api_secret,
    //                 ...$proxy
    //             ],
    //             'order' => [
    //                 "symbol" => "BTCUSDT",
    //                 "orderId" => $sell->order_id
    //             ]
    //         ];
    //     }

    //     $response = check_status_order($mdata);
    //     unset($mdata);

    //     $mdata = [];

    //     foreach ($response as $order) {
    //         if ($order["status"] == "FILLED") {
    //             $mdata['order_ids'][] = $order["orderId"];
    //         }
    //     }

    //     if (empty($mdata)) {
    //         return $this->respond(error_msg(200, "buy", null, 'order may be is pending!'), 200);
    //     }

    //     return $mdata;
    // }
}
