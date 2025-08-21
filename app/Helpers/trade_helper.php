<?php
function multi_limit_order($orders)
{
    $url = BINANCEAPI . "/order";
    $mh = curl_multi_init();
    $handles = [];
    $responses = [];

    foreach ($orders as $data) {
        $member = $data['member'];
        $data['order']["timestamp"] = round(microtime(true) * 1000);

        $query_string = http_build_query($data['order']);
        $signature = hash_hmac('sha256', $query_string, $member['api_secret']);
        $full_url = $url . "?" . $query_string . "&signature=" . $signature;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-MBX-APIKEY: " . $member['api_key'],
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);

        // Proxy
        curl_setopt($ch, CURLOPT_PROXY, $member['ip_address'] . ':' . $member['port']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $member['username'] . ':' . $member['password']);

        curl_multi_add_handle($mh, $ch);
        $handles[] = ['id_member' => $member["id_member"], 'handle' => $ch]; // Simpan sebagai array
    }

    do {
        $status = curl_multi_exec($mh, $running);
    } while ($running > 0);

    foreach ($handles as $handle_data) {
        $ch = $handle_data['handle'];
        $id_member = $handle_data['id_member'];
        $response = json_decode(curl_multi_getcontent($ch), true);
        
        $responses[] = [
            'id_member' => $id_member,
            ...$response
        ];
        
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
    }

    curl_multi_close($mh);
    log_message('info', 'BINANCE ORDER RESULT: ' . json_encode($responses));
    return $responses;
}

function check_status_order($mdata)
{
    $url = BINANCEAPI . "/order";
    $mh = curl_multi_init();
    $handles = [];
    $responses = [];

    foreach ($mdata as $data) {
        $member = $data['member'];
        // Tambahkan timestamp
        $data['order']["timestamp"] = round(microtime(true) * 1000);

        // Buat query string & tanda tangan (signature)
        $query_string = http_build_query($data['order']);
        $signature = hash_hmac('sha256', $query_string, $member['api_secret']);
        $full_url = $url . "?" . $query_string . "&signature=" . $signature;

        // Konfigurasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-MBX-APIKEY: " . $member['api_key'],
            "Content-Type: application/json"
        ]);

        // proxy
        curl_setopt($ch, CURLOPT_PROXY, $member['ip_address'] .':' . $member['port'] );
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $member['username'] .':' . $member['password']);

        // Tambahkan ke multi cURL
        curl_multi_add_handle($mh, $ch);
        $handles[$data['member']["id_member"]] = $ch;
    }

    do {
        $status = curl_multi_exec($mh, $running);
    } while ($running > 0);

    // Ambil respons dari setiap order
    foreach ($handles as $id_member => $ch) {
        $response = json_decode(curl_multi_getcontent($ch), true);
        $responses[] = [
            ...$response,
            'member_id' => $id_member
        ];
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
    }

    curl_multi_close($mh);
    return $responses;

}

function check_balances($mdata)
{
    $url = BINANCEAPI . "/account";
    $mh = curl_multi_init();
    $handles = [];

    foreach ($mdata as $data) {
        $member = $data['member'];
        $timestamp = round(microtime(true) * 1000);

        $query_string = http_build_query(['timestamp' => $timestamp]);
        $signature = hash_hmac('sha256', $query_string, $member['api_secret']);
        $full_url = $url . "?" . $query_string . "&signature=" . $signature;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-MBX-APIKEY: " . $member['api_key'],
            "Content-Type: application/json"
        ]);

        // Proxy
        curl_setopt($ch, CURLOPT_PROXY, $member['ip_address'] . ':' . $member['port']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $member['username'] . ':' . $member['password']);

        curl_multi_add_handle($mh, $ch);
        $handles[$data['member']["id_member"]] = $ch;
    }

    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);

    // Langsung simpan hasilnya dalam satu array tanpa looping tambahan
    $responses = [];
    foreach ($handles as $id_member => $ch) {
        $response = json_decode(curl_multi_getcontent($ch), true);
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);

        $balances = array_reduce(
            $response['balances'],
            function ($carry, $b) {
                if ($b['asset'] === 'BTC' || $b['asset'] === 'USDT') {
                    $carry[strtolower($b['asset'])] = $b['free'];
                }
                return $carry;
            },
            ['btc' => '0', 'usdt' => '0'] // Default jika tidak ada balance
        );

        $responses[$id_member] = $balances;
    }

    curl_multi_close($mh);
    return $responses;
}


function cancel_orders($orders, $proxies)
{
    $url = BINANCEAPI . "/order";
    $mh = curl_multi_init();
    $handles = [];

    foreach ($orders as $data) {;
        $proxy_key = array_rand($proxies);
        $proxy = (array) $proxies[$proxy_key];
        $timestamp = round(microtime(true) * 1000);

        $params = [
			"symbol" => "BTCUSDT",
			"orderId" => $data->order_id,
            'timestamp' => $timestamp
		];

        $query_string = http_build_query($params);
        $signature = hash_hmac('sha256', $query_string, $data->api_secret);
        $full_url = $url . "?" . $query_string . "&signature=" . $signature;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-MBX-APIKEY: " . $data->api_key,
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        // Proxy
        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip_address'] . ':' . $proxy['port']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['username'] . ':' . $proxy['password']);

        curl_multi_add_handle($mh, $ch);
        $handles[$data->order_id] = $ch;
    }

    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);

    // Langsung simpan hasilnya dalam satu array tanpa looping tambahan
    $responses = [];
    foreach ($handles as $id_member => $ch) {
        $response = json_decode(curl_multi_getcontent($ch), true);
        $responses[] = [
            ...$response
        ];
    }

    curl_multi_close($mh);
    return $responses;
}


function binanceAPI($url, $params = [], $method = "GET")
{
    $api_key = getenv("BINANCE_API_KEY");
    $api_secret = getenv("BINANCE_SECRET_KEY");
    $timestamp = round(microtime(true) * 1000);
    $params += ['timestamp' => $timestamp];
    $query_string = http_build_query($params);
    
    // Buat tanda tangan (signature)
    $signature = hash_hmac('sha256', $query_string, $api_secret);
    
    // Konfigurasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . "?" . $query_string . "&signature=" . $signature);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-MBX-APIKEY: $api_key",
        "Content-Type: application/json"
    ]);

    if ($method === "POST") {
        curl_setopt($ch, CURLOPT_POST, true);
    }

    elseif ($method === "DELETE") {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    }
    
    // Eksekusi request
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Tampilkan hasil
    $result = json_decode($response);
    return $result;
}