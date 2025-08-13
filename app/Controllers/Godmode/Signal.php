<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Signal extends BaseController
{

    public function index()
    {

        // Call Endpoint read latest signal from elite
        $url = URL_HEDGEFUND . "/v1/order/latestsignal";
        $response = satoshiAdmin($url);

        // Initial Array Buy A, Buy B, Buy C, dan Buy D
        $buy_a = array();
        $buy_b = array();
        $buy_c = array();
        $buy_d = array();

        // Variabel untuk menyimpan ID terbaru untuk setiap tipe buy
        $latest_buy_a_id = 0;
        $latest_buy_b_id = 0;
        $latest_buy_c_id = 0;
        $latest_buy_d_id = 0;

        // Periksa apakah respons valid dan berisi data
        if (isset($response->result) && isset($response->result->message)) {
            $result = $response->result->message;

            // Jika result adalah string "No buy orders found!", tidak perlu melakukan looping
            if (is_string($result) && $result === "No buy orders found!") {
                log_message('info', 'Tidak ada buy orders yang ditemukan');
            }
            // Pastikan result adalah array atau objek sebelum melakukan loop
            else if (is_array($result) || is_object($result)) {
                // Looping untuk mendapatkan data terbaru untuk setiap tipe buy
                foreach ($result as $dt) {
                    // Type Buy A
                    if ($dt->type == 'Buy A' && $dt->id > $latest_buy_a_id) {
                        $latest_buy_a_id = $dt->id;
                        $buy_a['id'] = $dt->id;
                        $buy_a['type'] = $dt->type;
                        $buy_a['entry_price'] = floatval($dt->entry_price);
                        $buy_a['status'] = $dt->status;
                        // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                        $buy_a['pair_id'] = $dt->id;

                        $buy_a['sell_id'] = $dt->sell_id ?? null;
                        $buy_a['sell_entry_price'] = floatval($dt->sell_entry_price ?? null);
                        $buy_a['sell_status'] = $dt->sell_status ?? null;
                        if (isset($dt->created_at)) $buy_a['created_at'] = $dt->created_at;
                    }
                    // Type Buy B
                    else if ($dt->type == 'Buy B' && $dt->id > $latest_buy_b_id) {
                        $latest_buy_b_id = $dt->id;
                        $buy_b['id'] = $dt->id;
                        $buy_b['type'] = $dt->type;
                        $buy_b['entry_price'] = floatval($dt->entry_price);
                        $buy_b['status'] = $dt->status;
                        // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                        $buy_b['pair_id'] = $dt->id;
                        $buy_b['sell_id'] = $dt->sell_id ?? null;
                        $buy_b['sell_entry_price'] = floatval($dt->sell_entry_price ?? null);
                        $buy_b['sell_status'] = $dt->sell_status ?? null;
                        if (isset($dt->created_at)) $buy_b['created_at'] = $dt->created_at;
                    }
                    // Type Buy C
                    else if ($dt->type == 'Buy C' && $dt->id > $latest_buy_c_id) {
                        $latest_buy_c_id = $dt->id;
                        $buy_c['id'] = $dt->id;
                        $buy_c['type'] = $dt->type;
                        $buy_c['entry_price'] = floatval($dt->entry_price);
                        $buy_c['status'] = $dt->status;
                        // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                        $buy_c['pair_id'] = $dt->id;
                        $buy_c['sell_id'] = $dt->sell_id ?? null;
                        $buy_c['sell_entry_price'] = floatval($dt->sell_entry_price ?? null);
                        $buy_c['sell_status'] = $dt->sell_status ?? null;
                        if (isset($dt->created_at)) $buy_c['created_at'] = $dt->created_at;
                    }
                    // Type Buy D
                    else if ($dt->type == 'Buy D' && $dt->id > $latest_buy_d_id) {
                        $latest_buy_d_id = $dt->id;
                        $buy_d['id'] = $dt->id;
                        $buy_d['type'] = $dt->type;
                        $buy_d['entry_price'] = floatval($dt->entry_price);
                        $buy_d['status'] = $dt->status;
                        // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                        $buy_d['pair_id'] = $dt->id;
                        $buy_d['sell_id'] = $dt->sell_id ?? null;
                        $buy_d['sell_entry_price'] = floatval($dt->sell_entry_price ?? null);
                        $buy_d['sell_status'] = $dt->sell_status ?? null;
                        if (isset($dt->created_at)) $buy_d['created_at'] = $dt->created_at;
                    }
                }
            } else {
                // Log error jika result bukan array atau objek dan bukan string yang diharapkan
                log_message('error', 'Result bukan array atau objek: ' . gettype($result));
                log_message('error', 'Isi result: ' . json_encode($result));
            }
        } else {
            // Log error jika respons tidak valid
            log_message('error', 'Respons tidak valid dari endpoint latestsignal');
        }

        // Call Endpoin read history all signal
        // $url = URLAPI . "/v1/signal/readhistory";
        // $resultActive = satoshiAdmin($url)->result->message;

        // Data dummy untuk history - kosongkan
        $resultActive = [];

        // initialitation variable dengan tipe data array
        $newarray = [];
        $tempGroup = [];

        // Looping for grouping per period, pembatas field is Buy A again
        foreach ($resultActive as $key => $dt) {
            $temp = (object) [
                'id' => $dt->id,
                'type' => $dt->type,
                'entry_price' => $dt->entry_price,
                'pair_id' => $dt->pair_id,
                'created_at' => $dt->created_at,
                'update_at' => $dt->update_at,
            ];

            array_push($tempGroup,  $temp);

            if ($dt->type == 'Buy A') {
                array_push($newarray, $tempGroup);
                $tempGroup = [];
                // stop hanya index ke 0
                break;
            }
        }

        $session = session();
        $user = $session->get('logged_user');
        $api_key = $user->api_key;
        $api_secret = $user->api_secret;

        // For get instruction last order
        $order = '';
        $lastdate = '';
        $temp_price = '';
        $order = '';
        $lastdate = '';

        $mdata = [
            'title'     => 'Signal - ' . NAMETITLE,
            'content'   => 'godmode/signal/index',
            'extra'     => 'godmode/signal/js/_js_index',
            'active_signal'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active',
            'buy_a'      => $buy_a,
            'buy_b'      => $buy_b,
            'buy_c'      => $buy_c,
            'buy_d'      => $buy_d,
            'order'      => $order,
            'lastdate'      => $lastdate,
            'api_key'      => $api_key,
            'api_secret'      => $api_secret,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function buysignal()
    {
        $result = [
            'code' => 201,
            'message' => []
        ];

        // Validation Field
        $rules = $this->validate([
            'price' => [
                'label' => 'Entry Price',
                'rules' => 'required'
            ],
            'type' => [
                'label' => 'Type Signal',
                'rules' => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $result = [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())
            ];
            echo json_encode($result);
            exit();
        }

        $session = session();
        $user = $session->get('logged_user');
        $admin_id = $user->id;
        $ip_address = $this->request->getIPAddress();

        // Initial Data
        $mdata = [
            'limit' => htmlspecialchars($this->request->getVar('price')),
            'type' => htmlspecialchars($this->request->getVar('type')),
            'admin_id' => $admin_id,
            'ip_address' => $ip_address,
        ];

        // Change format price (hapus koma jika ada)
        $mdata['limit'] = str_replace(',', '', $mdata['limit']);

        // Process Call to Hedgefund Endpoint API (limit_buy)
        $urlHedgefund = URL_HEDGEFUND . "/v1/order/limit_buy";
        $hedgefund = satoshiAdmin($urlHedgefund, json_encode($mdata));
        $message = $this->getMessage($hedgefund);

        if ($message->signal) {

            array_push($result['message'], 'Hedgefund: ' . $message->text);

            log_message('info', 'Response Buy dari endpoint Hedgefund: ' . json_encode($hedgefund));

            // Process Call to Lux Broker Endpoint API (limit_buy)
            $urlLux = URLAPI . "/v1/order/limit_buy";
            $mdata['signal_id'] = $message->signal;
            $lux = satoshiAdmin($urlLux, json_encode($mdata));
            array_push($result['message'], 'Lux Broker: ' . $this->getMessage($lux)->text);

            log_message('info', 'Response Buy dari endpoint Lux Broker: ' . json_encode($lux));
        } else {
            array_push($result['message'], 'Hedgefund: ' . $message->text);
        }

        // Return result as JSON
        echo json_encode($result);
    }


    public function sellsignal()
    {
        // Validation Field
        $rules = $this->validate([
            'price'     => [
                'label'     => 'Entry Price',
                'rules'     => 'required'
            ],
            'type'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
            'pair_id'  => [
                'label'     => 'Signal ID',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $response = [
                'code' => '400',
                'message' => $this->validator->listErrors()
            ];
            echo json_encode($response);
            exit();
        }

        // Dapatkan data user yang login
        $session = session();
        $user = $session->get('logged_user');
        $admin_id = $user->id;
        $ip_address = $this->request->getIPAddress();

        // Initial Data
        $mdata = [
            'admin_id'  => $admin_id,
            'ip_address' => $ip_address,
            // 'id_signal' => $this->request->getVar('pair_id'),
            'type'      => htmlspecialchars($this->request->getVar('type')),
            'limit'     => htmlspecialchars($this->request->getVar('price')),
        ];

        // Change format price
        $mdata['limit'] = str_replace(',', '', $mdata['limit']);

        // Call Endpoint read signal untuk mendapatkan daftar signal
        // ELITE API OR URL API FOR READ SIGNAL?

        $url = URL_HEDGEFUND . "/v1/order/latestsignal";
        $readsignal = satoshiAdmin($url)->result->message;
        log_message('info', 'Sinyal Akhir: ' . json_encode($readsignal));

        // Initial Alphabet
        $alphabet = ['A', 'B', 'C', 'D'];
        $result = null;
        $typesignal = $mdata['type'];

        // Log untuk debugging
        log_message('info', 'Memulai proses sell dengan tipe: ' . $typesignal);

        // Check Condition Signal Type
        if ($typesignal == 'SELL A') {
            foreach ($readsignal as $key => $val) {
                // Assign value sell signal
                // $mdata['type'] = 'SELL ' . $alphabet[$key];
                $mdata['type'] = str_replace("Buy", "SELL", $val->type);
                $mdata['id_signal'] = $val->id;

                // Send ke endpoint ketiga (URLAPI) untuk SELL
                $url3 = URL_HEDGEFUND . "/v1/order/limit_sell";
                $response3 = satoshiAdmin($url3, json_encode($mdata));
                log_message('info', 'Response dari endpoint elite limit_sell: ' . json_encode($response3));

                $result = $response3->result;

                // send signal to pn &satoshi
                if (isset($result->message) && isset($result->message->id)) {
                    $mdata['id_signal'] = $result->message->id;
                    $mdata['pair_id'] = $val->id;
                    $this->send_signal_sell($mdata);
                }
                sleep(1);
            }
        } else if ($typesignal == 'SELL B') {
            // initial Flag Buy B
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy B
                if ($val->type === 'Buy B') {
                    $startCheck = true;
                }

                // Checking Flag Buy B and other
                if ($startCheck) {
                    // Assign value sell signal
                    // $mdata['type'] = 'SELL ' . $alphabet[$key];
                    $mdata['type'] = str_replace("Buy", "SELL", $val->type);
                    $mdata['id_signal'] = $val->id;

                    // Send ke endpoint pertama (URLAPI) untuk SELL
                    $url3 = URL_HEDGEFUND . "/v1/order/limit_sell";
                    $response3 = satoshiAdmin($url3, json_encode($mdata));
                    log_message('info', 'Response dari endpoint limit_sell: ' . json_encode($response3));

                    $result = $response3->result;
                    // send signal to pn &satoshi
                    if (isset($result->message) && isset($result->message->id)) {
                        $mdata['id_signal'] = $result->message->id;
                        $mdata['pair_id'] = $val->id;
                        $this->send_signal_sell($mdata);
                    }

                    sleep(1);
                }
            }
        } else if ($typesignal == 'SELL C') {
            // initial Flag Buy C
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy C
                if ($val->type === 'Buy C') {
                    $startCheck = true;
                }

                // Checking Flag Buy C and other
                if ($startCheck) {
                    // Assign value sell signal
                    // $mdata['type'] = 'SELL ' . $alphabet[$key];
                    $mdata['type'] = str_replace("Buy", "SELL", $val->type);
                    $mdata['id_signal'] = $val->id;

                    // Send ke endpoint ketika (URL_HEDGEFUND) untuk SELL
                    $url3 = URL_HEDGEFUND . "/v1/order/limit_sell";
                    $response3 = satoshiAdmin($url3, json_encode($mdata));
                    log_message('info', 'Response dari endpoint limit_sell: ' . json_encode($response3));

                    $result = $response3->result;
                    // send signal to pn &satoshi
                    if (isset($result->message) && isset($result->message->id)) {
                        $mdata['id_signal'] = $result->message->id;
                        $mdata['pair_id'] = $val->id;
                        $this->send_signal_sell($mdata);
                    }

                    sleep(1);
                }
            }
        } else if ($typesignal == 'SELL D') {
            // initial Flag Buy D
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy D
                if ($val->type === 'Buy D') {
                    $startCheck = true;
                }

                // Checking Flag Buy D and other
                if ($startCheck) {
                    // Assign value sell signal
                    // $mdata['type'] = 'SELL ' . $alphabet[$key];
                    $mdata['type'] = str_replace("Buy", "SELL", $val->type);
                    $mdata['id_signal'] = $val->id;

                    // Send ke endpoint pertama (URLAPI) untuk SELL
                    $url3 = URL_HEDGEFUND . "/v1/order/limit_sell";
                    $response3 = satoshiAdmin($url3, json_encode($mdata));
                    log_message('info', 'Response dari endpoint limit_sell: ' . json_encode($response3));

                    $result = $response3->result;
                    // send signal to pn &satoshi
                    if (isset($result->message) && isset($result->message->id)) {
                        $mdata['id_signal'] = $result->message->id;
                        $mdata['pair_id'] = $val->id;
                        $this->send_signal_sell($mdata);
                    }
                }
            }
        }

        $response = $response3;

        log_message('info', 'Akhir Respond diterima: ' . json_encode($response));

        // Periksa apakah response memiliki result dan code
        if (isset($response->result)) {
            if (isset($response->result->code) && ($response->result->code == 200 || $response->result->code == 201)) {
                $result = [
                    'code' => $response->result->code,
                    'message' => isset($response->result->message) ? $response->result->message->text : 'Sell order successfully processed'
                ];
            } else {
                $result = [
                    'code' => isset($response->result->code) ? $response->result->code : 400,
                    'message' => isset($response->result->message) ? $response->result->message : 'Failed to process sell order'
                ];
            }
        } else if (isset($response->status)) {
            // Handle kasus dimana hanya ada status
            if ($response->status == 200 || $response->status == 201) {
                $result = [
                    'code' => $response->status,
                    'message' => 'Sell order successfully processed'
                ];
            } else {
                $result = [
                    'code' => $response->status,
                    'message' => 'Failed to process sell order'
                ];
            }
        } else {
            $result = [
                'code' => 500,
                'message' => 'Invalid response format from server'
            ];
        }

        // Log hasil akhir
        log_message('info', 'Hasil akhir proses sell: ' . json_encode($result));

        // Return result as JSON
        echo json_encode($result);
    }

    public function fillsignal()
    {
        // Dapatkan ID signal dari request jika ada
        $id_signal = $this->request->getVar('id_signal');

        // Jika masih tidak ada id_signal, kirim error
        if (!$id_signal) {
            $result = [
                'code' => '400',
                'message' => 'Signal not found'
            ];
            echo json_encode($result);
            exit();
        }

        // Daftar endpoint yang akan dicoba
        $endpoints = [
            URLAPI . "/v1/order/fill_order?id_signal=" . $id_signal,
            URLAPI . "/v1/order/fill?id_signal=" . $id_signal,
            URLAPI . "/v1/order/fillOrder?id_signal=" . $id_signal,
            URLAPI . "/v1/order/fill-order?id_signal=" . $id_signal
        ];

        $response = null;
        $success = false;

        // Coba setiap endpoint sampai berhasil
        foreach ($endpoints as $url) {
            // Log untuk debugging
            log_message('info', 'Mencoba endpoint: ' . $url);

            // Proccess Call Endpoin API
            $response = satoshiAdmin($url);

            // Log respons untuk debugging
            log_message('info', 'Respons dari endpoint: ' . json_encode($response));

            // Periksa apakah respons berhasil
            if (isset($response->status) && $response->status == 200 && isset($response->result)) {
                $success = true;
                log_message('info', 'Endpoint berhasil: ' . $url);
                break;
            }
        }

        // Jika tidak ada endpoint yang berhasil, coba dengan metode POST
        if (!$success) {
            // Dapatkan data user yang login
            $session = session();
            $user = $session->get('logged_user');
            $admin_id = $user->id;
            $ip_address = $this->request->getIPAddress();

            // Siapkan data untuk dikirim ke API
            $mdata = [
                'id_signal' => $id_signal,
                'admin_id'  => $admin_id,
                'ip_address' => $ip_address
            ];

            // Daftar endpoint POST yang akan dicoba
            $post_endpoints = [
                URLAPI . "/v1/order/fill_order",
                URLAPI . "/v1/order/fill",
                URLAPI . "/v1/order/fillOrder",
                URLAPI . "/v1/order/fill-order"
            ];

            foreach ($post_endpoints as $url) {
                // Log untuk debugging
                log_message('info', 'Mencoba endpoint POST: ' . $url . ' dengan data: ' . json_encode($mdata));

                // Proccess Call Endpoin API dengan metode POST
                $response = satoshiAdmin($url, json_encode($mdata));

                // Log respons untuk debugging
                log_message('info', 'Respons dari endpoint POST: ' . json_encode($response));

                // Periksa apakah respons berhasil
                if (isset($response->status) && $response->status == 200 && isset($response->result)) {
                    $success = true;
                    log_message('info', 'Endpoint POST berhasil: ' . $url);
                    break;
                }
            }
        }

        // Periksa respons dari API
        if (isset($response->result) && is_object($response->result)) {
            // Jika ada result, gunakan itu
            $result = (array) $response->result;

            // Pastikan ada kode status
            if (!isset($result['code'])) {
                $result['code'] = $success ? '200' : '400';
            }

            // Pastikan ada pesan
            if (!isset($result['message'])) {
                $result['message'] = $success
                    ? 'Order Successfully Filled'
                    : 'Failed to fill order';
            }
        } else {
            // Jika tidak ada result, buat respons default
            $result = [
                'code' => $success ? '200' : '400',
                'message' => $success
                    ? 'Order Successfully Filled'
                    : 'Failed to fill order'
            ];

            // Jika ada error message dari API, gunakan itu
            if (isset($response->error) && isset($response->error->message)) {
                $result['message'] = $response->error->message;
            }
        }

        // Tambahkan informasi tambahan jika diperlukan
        $result['timestamp'] = date('Y-m-d H:i:s');
        $result['id_signal'] = $id_signal;
        $result['success'] = $success;

        // Kembalikan hasil sebagai JSON
        echo json_encode($result);
    }

    public function deletesignal()
    {
        // Validation Field
        $rules = $this->validate([
            'id_signal' => [
                'label' => 'Signal ID',
                'rules' => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $response = [
                'code' => '400',
                'message' => $this->validator->listErrors()
            ];
            echo json_encode($response);
            exit();
        }

        // Initial Data
        $signal_id = htmlspecialchars($this->request->getVar('id_signal'));
        $mdata = [
            'id_signal' => $signal_id,
        ];

        // Log untuk debugging
        log_message('info', 'Mencoba menghapus signal dengan ID: ' . $signal_id);

        // Process Call to Second Endpoint API (ELITE)
        $url3 = URL_HEDGEFUND . "/v1/order/delete?id_signal=" . $signal_id;
        $response1 = satoshiAdmin($url3);

        // Log response dari endpoint ketiga
        log_message('info', 'Response dari endpoint delete ketiga: ' . json_encode($response1));

        // // Determine the primary response based on first endpoint
        if (isset($response1->result) && isset($response1->result->code)) {
            $result = [
                'code' => $response1->result->code,
                'message' => $response1->result->message
            ];

            if ($response1->result->code == 200 || $response1->result->code == 201) {
                $this->send_signal_cancel($signal_id);
            }
        } else {
            // Fallback if first endpoint response is unexpected
            $result = [
                'code' => isset($response1->error) ? '400' : '200',
                'message' => isset($response1->error->message) ? $response1->error->message : 'Signal deleted'
            ];
        }

        echo json_encode($result);
    }

    public function list_history_order()
    {
        // Call Endpoin List History Order
        $url = URL_HEDGEFUND . "/v1/order/get_all";
        $response = satoshiAdmin($url);

        // Periksa apakah respons valid dan berisi data
        if (isset($response->result) && isset($response->result->message)) {
            $result = $response->result->message;

            // Jika result adalah string, kembalikan array kosong
            if (is_string($result)) {
                log_message('info', 'Respons dari get_all adalah string: ' . $result);
                echo json_encode([]);
                return;
            }

            // Jika result adalah array atau objek, kembalikan apa adanya
            echo json_encode($result);
        } else {
            // Jika respons tidak valid, kembalikan array kosong
            log_message('error', 'Respons tidak valid dari endpoint get_all');
            echo json_encode([]);
        }
    }

    public function cancel_sell()
    {
        $signal_id = htmlspecialchars($_GET['id']);
        log_message('info', 'Signal ID: ' . $signal_id);

        // Panggil endpoint pertama (URLAPI)
        $url1 = URLAPI . "/v1/order/delete?id_signal=" . $signal_id;
        $response1 = satoshiAdmin($url1);

        // Log response dari endpoint pertama
        log_message('info', 'Response from first endpoint: ' . json_encode($response1));

        // Panggil endpoint kedua (URLAPI2)
        $url2 = URLAPI2 . "/v1/signal/cancelsignal?id=" . $signal_id;
        $response2 = satoshiAdmin($url2);

        // Log response dari endpoint kedua
        log_message('info', 'Response from second endpoint: ' . json_encode($response2));

        // Determine the primary response based on both endpoints
        if (
            isset($response1->result) && isset($response1->result->code) &&
            isset($response2->result) && isset($response2->result->code)
        ) {
            // Both endpoints successful
            if (($response1->result->code == '200' || $response1->result->code == '201') &&
                ($response2->result->code == '200' || $response2->result->code == '201')
            ) {
                $result = (object)[
                    'code' => '200',
                    'message' => 'Signal cancelled successfully'
                ];
            } else {
                // At least one endpoint failed
                $result = (object)[
                    'code' => '400',
                    'message' => 'Failed to cancel signal on one or more endpoints'
                ];
            }
        } else {
            // Handle case where at least one endpoint returned unexpected response
            $result = (object)[
                'code' => '400',
                'message' => 'Failed to cancel signal: Unexpected response from endpoints'
            ];
        }

        // Set flash message based on result
        if ($result->code == '200') {
            session()->setFlashdata('success', $result->message);
        } else {
            session()->setFlashdata('failed', $result->message);
        }

        // Redirect back to signal page
        return redirect()->to(BASE_URL . 'godmode/signal');
    }

    // private function send_signal_buy($mdata) {

    // send to pnglobal
    // $url = URLAPI . '/v1/order/limit_buy';
    // $response = satoshiAdmin($url, json_encode($mdata));
    // log_message('info', 'Response dari endpoint limit_buy PNGLOBAL: ' . json_encode($response));

    // send to satoshi
    // $url = URLAPI . '/v1/order/limit_buy';
    // $response = satoshiAdmin($url, json_encode($mdata));
    // log_message('info', 'Response dari endpoint limit_buy Satoshi: ' . json_encode($response));
    // }

    private function send_signal_sell($mdata)
    {

        // send to pnglobal
        $url = URLAPI . '/v1/order/limit_sell';
        $response = satoshiAdmin($url, json_encode($mdata));
        log_message('info', 'Response dari endpoint limit_sell PNGLOBAL: ' . json_encode($response));

        // send to satoshi
        // $url = URLAPI . '/v1/order/limit_buy';
        // $response = satoshiAdmin($url, json_encode($mdata));
        // log_message('info', 'Response dari endpoint limit_buy Satoshi: ' . json_encode($response));
    }

    private function send_signal_cancel($signal_id)
    {

        // send to pnglobal
        $url = URLAPI . '/v1/order/delete?id_signal=' . $signal_id;
        $response = satoshiAdmin($url);
        log_message('info', 'Response dari endpoint cancel PNGLOBAL: ' . json_encode($response));

        // send to satoshi
        // $url = URLAPI . '/v1/order/limit_buy';
        // $response = satoshiAdmin($url, json_encode($mdata));
        // log_message('info', 'Response dari endpoint limit_buy Satoshi: ' . json_encode($response));
    }

    private function getMessage($res)
    {
        if (isset($res->result->message->text)) {
            return (object) [
                'text' => $res->result->message->text,
                'signal' => $res->result->message->id ?? null
            ];
        } elseif (isset($res->result->message) && is_string($res->result->message)) {
            return (object) [
                'text' => $res->result->message,
                'signal' => null
            ];
        }
        return (object) [
            'text' => 'No response message',
            'signal' => null
        ];
    }

    public function getmember_balance()
    {
        // Call Endpoint Get Total Member
        $url = URL_HEDGEFUND . "/v1/member/get_totalbalance";
        $result = satoshiAdmin($url)->result;
    
        return $this->response->setJSON($result->message);
    }

    // Force Cancel
    public function cancelsignal()
    {
        if (!$this->validate([
            'idsignal' => 'required'
        ])) {
            $result =  [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())
            ];
            echo json_encode($result);
            exit();
        }
    
        $idsignal = rawurlencode($this->request->getVar('idsignal'));
    
        $url = URL_HEDGEFUND . "/v1/order/cancel_signal?id_signal=".$idsignal;
        $response = satoshiAdmin($url)->result ?? null;
    
        log_message('info', 'Update order: ' . json_encode($url));
    
        $result = [
            'code' => ($response && $response->code == 201) ? 200 : 400,
            'message' => [$response->message ?? 'Unknown error']
        ];
        echo json_encode($result);
    }

    // FILL BUY
    public function fillbuy()
    {
        if (!$this->validate([
            'price' => 'required',
            'type' => 'required|in_list[BUY A,BUY B, BUY C, BUY D]',
            'idsignal' => 'required'
        ])) {
            $result =  [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())
            ];
            echo json_encode($result);
            exit();
        }
    
        $price = str_replace(',', '', $this->request->getVar('price'));
        $type = rawurlencode($this->request->getVar('type'));
        $idsignal = rawurlencode($this->request->getVar('idsignal'));
    
        $url = URL_HEDGEFUND . "/updateorder/filled_buy?buy_id=$idsignal&filled_price=$price&type_buy=$type";
        $response = satoshiAdmin($url)->result ?? null;
    
        log_message('info', 'Update order: ' . json_encode($response));
    
        $result = [
            'code' => ($response && $response->code == 201) ? 200 : 400,
            'message' => [$response->message ?? 'Unknown error']
        ];
        echo json_encode($result);
    }

    // FILL SELL
    public function fillsell()
    {
        if (!$this->validate([
            'type' => 'required|in_list[SELL A,SELL B, SELL C, SELL D]',
        ])) {
            $result =  [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())
            ];
            echo json_encode($result);
            exit();
        }

        $msg = [
            'code' => 200,
            'message' => []
        ];
        $typesignal = $this->request->getVar('type');

        $url = URL_HEDGEFUND . "/v1/order/latestsignal";
        $readsignal = satoshiAdmin($url)->result->message;
        // Check Condition Signal Type
        if ($typesignal == 'SELL A') {
            foreach ($readsignal as $key => $val) {

                // Send fill sell
                $url = URL_HEDGEFUND . "/updateorder/filled_sell?buy_id=$val->id&filled_price=$val->sell_entry_price&sell_id=$val->sell_id";
                $response = satoshiAdmin($url)->result ?? null;

                $msg['message'][] = $response->message ?? 'Unknown error';

                sleep(1);
            }
        } else if ($typesignal == 'SELL B') {
            // initial Flag Buy B
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy B
                if ($val->type === 'Buy B') {
                    $startCheck = true;
                }

                // Checking Flag Buy B and other
                if ($startCheck) {
                    // Send fill sell
                    $url = URL_HEDGEFUND . "/updateorder/filled_sell?buy_id=$val->id&filled_price=$val->sell_entry_price&sell_id=$val->sell_id";
                    $response = satoshiAdmin($url)->result ?? null;

                    $msg['message'][] = $response->message ?? 'Unknown error';

                    sleep(1);
                }
            }
        } else if ($typesignal == 'SELL C') {
            // initial Flag Buy C
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy C
                if ($val->type === 'Buy C') {
                    $startCheck = true;
                }

                // Checking Flag Buy C and other
                if ($startCheck) {
                    // Send fill sell
                    $url = URL_HEDGEFUND . "/updateorder/filled_sell?buy_id=$val->id&filled_price=$val->sell_entry_price&sell_id=$val->sell_id";
                    $response = satoshiAdmin($url)->result ?? null;

                    $msg['message'][] = $response->message ?? 'Unknown error';

                    sleep(1);
                }
            }
        } else if ($typesignal == 'SELL D') {
            // initial Flag Buy D
            $startCheck = false;
            foreach ($readsignal as $key => $val) {
                // Get Flag Buy D
                if ($val->type === 'Buy D') {
                    $startCheck = true;
                }

                // Checking Flag Buy D and other
                if ($startCheck) {
                    // Send fill sell
                    $url = URL_HEDGEFUND . "/updateorder/filled_sell?buy_id=$val->id&filled_price=$val->sell_entry_price&sell_id=$val->sell_id";
                    $response = satoshiAdmin($url)->result ?? null;

                    $msg['message'][] = $response->message ?? 'Unknown error';
                }
            }
        }

        
        echo json_encode($msg);
    } 

}
