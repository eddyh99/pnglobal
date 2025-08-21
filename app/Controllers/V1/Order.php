<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;

class Order extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->subscribe  = model('App\Models\V1\Mdl_subscribe');
        $this->signal  = model('App\Models\V1\Mdl_signal');
        $this->member_signal  = model('App\Models\V1\Mdl_member_signal');
        $this->proxy  = model('App\Models\V1\Mdl_proxies');
    }

    public function postLimit_buy()
    {

        $validation = $this->validation;
        $validation->setRules([
            'type' => [
                'rules'  => 'required|in_list[BUY A,BUY B,BUY C,BUY D]',
                'errors' => [
                    'required' => 'Type is required',
                    'in_list'  => 'Invalid type, allowed types: BUY A, BUY B, BUY C, BUY D'
                ]
            ],
            'limit' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' =>  [
                    'required'     => 'Limit is required',
                    'numeric'      => 'Limit must be a number',
                    'greater_than' => 'Limit must be greater than 0'
                ]
            ],
            'admin_id' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required'     => 'Admin ID is required',
                    'integer'      => 'Admin ID must be an integer',
                ]
            ],
            'signal_id' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required'     => 'Signal ID is required',
                    'integer'      => 'Signal ID must be an integer',
                ]
            ],
            'ip_address' => [
                'rules'  => 'required|valid_ip',
                'errors' => [
                    'required'  => 'IP Address is required',
                    'valid_ip'  => 'Invalid IP address format'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $data = $this->request->getJSON();
        // $latest_buy = $this->signal->get_latest_signals_buy();
        // if ($latest_buy->code != 200) {
        //     return $this->respond(error_msg(400, "binance", '01', 'Failed check previous order, try again'), 400);
        // }
        // log_message('error', 'Latest buy : '.json_encode($latest_buy));

        // $pending_order = array_filter($latest_buy->message, function ($order) {
        //     return $order->status === 'pending';
        // });

        // if (!empty($pending_order)) {
        //     return $this->respond(error_msg(400, "binance", '02', 'Previous order still pending'), 400);
        // }

        // $mdata = [
        //     'admin_id' => $data->admin_id,
        //     'ip_addr'  => $data->ip_address,
        //     'type' => $data->type,
        //     'entry_price' => $data->limit
        // ];

        // $signal = $this->signal->add($mdata);
        // if (@$signal->code != 201) {
        //     return $this->respond(error_msg(400, "signal", '01', $signal->message), 400);
        // }

        $members = $this->subscribe->getMember_initialCapital();

        if ($members->code != 200) {
            log_message('error', 'Init Capital : '.json_encode($members));
            exit();
        }

        $proxies = $this->get_proxies();

        if (!$proxies) {
            // log_message('error', 'Failed Proxy');
            // exit();
            return $this->respond(error_msg(400, "proxy", null, 'Failed Proxy'), 400);
        }


        // proses limit order
        $orders = $this->limit_order('BUY', $members->message ?? [], $data->limit, $proxies);
        log_message('error', 'Binance Order '.json_encode($orders));

        $member_signal = array_map(function ($order) use ($data) {
            return [
                'member_id' => $order['id_member'],
                'order_id' => $order['orderId'] ?? null,
                'amount_btc' => $order['origQty'] ?? 0,
                'sinyal_id'  => $data->signal_id
            ];
        }, $orders);

        $result = $this->member_signal->add($member_signal);
        log_message('error', 'Binance Order '.json_encode($member_signal));
        if (@$result->code != 201) {
            return $this->respond(error_msg(400, "order", null, $result->message), 400);
        }

        return $this->respond(error_msg(201, "order", null, $result->message), 201);
    }

    public function postLimit_sell()
    {

        $validation = $this->validation;
        $validation->setRules([
            'type' => [
                'rules'  => 'required|in_list[SELL A,SELL B,SELL C,SELL D]',
                'errors' => [
                    'required' => 'Type is required',
                    'in_list'  => 'Invalid type, allowed types: SELL A, SELL B, SELL C, SELL D'
                ]
            ],
            'id_signal' => [
                'rules'  => 'required|is_numeric',
                'errors' => [
                    'required' => 'Type is required',
                ]
            ],
            'pair_id' => [
                'rules'  => 'required|is_numeric',
                'errors' => [
                    'required' => 'Type is required',
                ]
            ],
            'limit' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' =>  [
                    'required'     => 'Limit is required',
                    'numeric'      => 'Limit must be a number',
                    'greater_than' => 'Limit must be greater than 0'
                ]
            ],
            'admin_id' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required'     => 'Admin ID is required',
                    'integer'      => 'Admin ID must be an integer',
                ]
            ],
            'ip_address' => [
                'rules'  => 'required|valid_ip',
                'errors' => [
                    'required'  => 'IP Address is required',
                    'valid_ip'  => 'Invalid IP address format'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $data = $this->request->getJSON();
        // $mdata = [
        //     'admin_id' => $data->admin_id,
        //     'ip_addr'  => $data->ip_address,
        //     'type' => $data->type,
        //     'entry_price' => $data->limit,
        //     'pair_id'   => $data->id_signal
        // ];

        // $signal = $this->signal->add($mdata, true);
        // if (@$signal->code != 201) {
        //     return $this->respond(error_msg(400, "signal", '01', $signal->message), 400);
        //     exit();
        // }

        $members = $this->signal->get_signals_for_sell($data->pair_id);

        if ($members->code != 200) {
            log_message('error', 'Get Signal '.json_encode($members->message));
            exit();
        }

        $proxies = $this->get_proxies();

        if (!$proxies) {
            log_message('error', 'Error Proxy ');
            exit();
        }

        // proses limit order
        $orders = $this->limit_order('SELL', $members->message ?? [], $data->limit, $proxies);

        $member_signal = array_map(function ($order) use ($data) {
            return [
                'member_id'  => $order['id_member'],
                'order_id'   => $order['orderId'] ?? null,
                'amount_btc' => $order['origQty'] ?? 0,
                'sinyal_id'  => $data->id_signal
            ];
        }, $orders);


        $result = $this->member_signal->add($member_signal);
        if (@$result->code != 201) {
            log_message('error', 'Signal Failed '.json_encode($result));
            exit();
        }

        return $this->respond(error_msg(201, "orders", null, $result->message), 201);
    }


    public function limit_order($side, $members, $limit, $proxies)
    {
        $mdata = [];
        $stepSize = 0.00001000;

        foreach ($members as $member) {
            $proxy_key = array_rand($proxies);
            $proxy = (array) $proxies[$proxy_key];

            if ($side == 'BUY') {        //buy
                $amount = $member->initial_capital / 4;
                $btc = $amount / $limit;
                $quantityBTC = floor($btc / $stepSize) * $stepSize;
            } else {      //sell    
                $quantityBTC = $member->amount_btc;
            }

            $mdata[] = [
                'member' => [
                    'id_member'  => $member->id,
                    'api_key'    => $member->api_key,
                    'api_secret' => $member->api_secret,
                    ...$proxy
                ],
                'order' => [
                    "symbol"      => "BTCUSDT",
                    "side"        => $side,
                    "type"        => "LIMIT",
                    "timeInForce" => "GTC",
                    "quantity"    => $quantityBTC,
                    "price"       => $limit,
                    "newClientOrderId" => 'order_' . bin2hex(random_bytes(10))
                ]
            ];

            if ($side == 'SELL' && isset($member->id_sinyal)) {
                $lastIndex = array_key_last($mdata);
                $mdata[$lastIndex]['member']['id_sinyal'] = $member->id_sinyal;
            }
        }

        $result = multi_limit_order($mdata);
        return $result;
    }

    public function postFill_order()
    {
        $id = filter_var($this->request->getVar('id_signal'), FILTER_SANITIZE_NUMBER_INT);
        $result = $this->signal->fill_order($id);
        if (@$result->code != 201) {
            return $this->respond(error_msg($result->code, "order", '01', $result->message), $result->code);
        }

        return $this->respond(error_msg(201, "order", null, $result->message), 201);
    }

    public function getGet_all()
    {
        $result = $this->signal->get_all();
        if (@$result->code != 200) {
            return $this->respond(error_msg($result->code, "order", '01', $result->message), $result->code);
        }

        return $this->respond(error_msg(200, "order", null, $result->message), 200);
    }

    public function get_proxies()
    {
        $result = $this->proxy->get_all();

        if (@$result->code != 200) {
            return false;
        }

        // filter proksi yang aktif
        $active_proxies = $this->get_active_proxies($result->message);

        if (empty($active_proxies)) {
            return false;
        }

        return $active_proxies;
    }

    private function get_active_proxies($proxies)
    {
        $mh = curl_multi_init();
        $handles = [];

        foreach ($proxies as $proxy) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://1.1.1.1/cdn-cgi/trace");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PROXY, "{$proxy->ip_address}:{$proxy->port}");
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

            if (!empty($proxy->username) && !empty($proxy->password)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$proxy->username}:{$proxy->password}");
            }

            curl_multi_add_handle($mh, $ch);
            $handles[$proxy->ip_address . ':' . $proxy->port] = ['ch' => $ch, 'proxy' => $proxy];
        }

        // Eksekusi semua request secara paralel
        do {
            $status = curl_multi_exec($mh, $active);
        } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

        // Ambil hanya proxy yang aktif
        $active_proxies = [];
        foreach ($handles as $key => $data) {
            $ch = $data['ch'];
            $proxy = $data['proxy'];

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);

            if ($http_code === 200 && empty($error)) {
                $active_proxies[] = $proxy; // Simpan hanya proxy yang aktif
            }

            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);

        return $active_proxies; // Hanya mengembalikan proxy yang aktif
    }

    public function getDelete()
    {
        $id_signal = filter_var($this->request->getVar('id_signal'), FILTER_SANITIZE_NUMBER_INT);
        $orders = $this->signal->get_orders($id_signal);
        log_message('error', json_encode($orders));

        if (@$orders->code != 200) {
            return $this->respond(error_msg($orders->code, "order", '01', $orders->message), $orders->code);
        }

        $proxies = $this->get_proxies();

        if (!$proxies) {
            log_message('error', json_encode($proxies));
            exit();
        }

        $response = cancel_orders($orders->message, $proxies);
        log_message('error', json_encode($response));

        $is_canceled = false;

        foreach ($response as $order) {
            if (isset($order["status"]) && $order["status"] === "CANCELED") {
                $is_canceled = true; // Tandai sebagai "cancel"
                break; // Hentikan iterasi setelah menemukan satu
            }
        }

        if (!$is_canceled) {
            log_message('error', "order may be is filled/canceled!");
        }

        return $this->respond(error_msg(201, "order", null, 'Order has been canceled.'), 201);
    }

    public function getAmount_last_order($type)
    {
        $types = [];
        switch ($type) {
            case 'Buy B':
                $types = ['Buy A'];
                break;
            case 'Buy C':
                $types = ['Buy A', 'Buy B'];
                break;
            case 'Buy D':
                $types = ['Buy A', 'Buy B', 'Buy C'];
                break;
            default:
                return [];
                break;
        }
        $result = $this->signal->get_amountBTC_last_order($types);
        if (@$result->code != 200) {
            return false;
        }

        return $result->message;
    }

    public function getLatestsignal()
    {
        $buys = $this->signal->get_latest_signals_buy();

        if (@$buys->code != 200) {
            return $this->respond(error_msg($buys->code, "order", '01', $buys->message), $buys->code);
        }

        if (empty($buys->message)) {
            return $this->respond(error_msg(404, "order", '01', 'No buy orders found!'), 404);
        }

        return $this->respond(error_msg(200, "buys", null, $buys->message), 200);
    }
    //

    public function getSell_all()
    {
        $qty = $this->request->getVar('qty');
        $url = BINANCEAPI . "/order";
        $params = [
            "symbol"      => "BTCUSDT",
            "side"        => 'SELL',
            "type"        => "MARKET",
            "quantity"    => $qty ?? 0,
        ];

        $response = binanceAPI($url, $params, 'POST');
        if (isset($response->code)) {
            return $this->respond(error_msg(400, "binance", $response->code, $response->msg), 400);
        }

        return $this->respond(error_msg(200, "binance", null, $response), 200);
    }

    public function getBalance()
    {
        $url = BINANCEAPI . "/account";

        $response = binanceAPI($url, []);
        if (isset($response->code)) {
            return $this->respond(error_msg(400, "binance", $response->code, $response->msg), 400);
        }

        return $this->respond(error_msg(200, "binance", null, $response), 200);
    }

    public function getStatus()
    {
        $order_id = $this->request->getVar('order_id');
        $url = BINANCEAPI . "/order";
        $params = [
            "symbol" => "BTCUSDT",
            "orderId" => $order_id
        ];

        $response = binanceAPI($url, $params);
        if (isset($response->code)) {
            return $this->respond(error_msg(400, "binance", $response->code, $response->msg), 400);
        }

        return $this->respond(error_msg(200, "binance", null, $response), 200);
    }

    public function postDelete_all()
    {
        $url = BINANCEAPI . "/openOrders";
        $params = [
            "symbol" => "BTCUSDT"
        ];
        $response = binanceAPI($url, $params, "DELETE");

        if (isset($response->code)) {
            return $this->respond(error_msg(400, "binance", $response->code, $response->msg), 400);
        }

        return $this->respond(error_msg(200, "binance", null, $response), 200);
    }

    public function getShow_all()
    {
        $url = BINANCEAPI . "/openOrders";
        $params = [
            "symbol" => "BTCUSDT"
        ];
        $response = binanceAPI($url, $params);

        if (isset($response->code)) {
            return $this->respond(error_msg(400, "binance", $response->code, $response->msg), 400);
        }

        return $this->respond(error_msg(200, "binance", null, $response), 200);
    }

    public function getTruncate_signals()
    {
        $result = $this->signal->truncate();

        if ($result->code !== 201) {
            return $this->respond(error_msg(400, "binance", $result->code, $result->message), 400);
        }

        return $this->respond(error_msg(201, "binance", null, $result->message), 201);
    }
}
