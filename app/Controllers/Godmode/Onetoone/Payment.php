<?php

namespace App\Controllers\Godmode\Onetoone;

use Config\Services;
use Hashids\Hashids;
use App\Controllers\BaseController;
use App\Models\MemberOnetoOneModel;

class Payment extends BaseController
{

    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        // Fetching all members for the dropdown
        $urlListMember = URL_HEDGEFUND . "/apiv1/onetoone/member";
        $resultMember = satoshiAdmin($urlListMember)->result;
        if (!$resultMember) {
            $resultMember = (object) [
                'data' => [],
                'message' => 'No members found.'
            ];
        }
        // Fetching all payment links
        $urlListPayment = URL_HEDGEFUND . "/apiv1/onetoone/list_payment/";
        $resultPayment = satoshiAdmin($urlListPayment)->result;

        $mdata = [
            'title'     => 'One To One - ' . NAMETITLE,
            'content'   => 'godmode/onetoone/payment',
            'extra'     => 'godmode/course/dashboard/js/_js_index',
            'sidebar'   => 'onetoone_sidebar',
            'navbar_onetoone' => 'active',
            'active_member'    => 'active active-menu',
            'member_onetoone' => $resultMember->data,
            'payment'  => $resultPayment,
            'payment_link'  => session()->getFlashdata('paymentlink'),
            'payment_email' => session()->getFlashdata('payment_email')
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function paymentlink()
    {
        // Validation Field
        $rules = $this->validate([
            'nominal' => [
                'label' => 'Nominal',
                'rules' => 'required|decimal'
            ],
            'currency' => [
                'label' => 'Currency',
                'rules' => 'required|in_list[usdt,usdc,stripe,banktransfer]'
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required'
            ]
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/onetoone/payment');
        }

        // Ambil nilai dari input
        $nominal     = htmlspecialchars($this->request->getVar('nominal'));
        $currency    = $this->request->getVar('currency');
        $description = htmlspecialchars($this->request->getVar('description'));
        $email       = htmlspecialchars($this->request->getVar('email'));

        // Membuat invoice number
        $salt = hash('sha256', $nominal . $description . $email . microtime(true));
        $CreateInvoiceNumber = new Hashids($salt, 6);

        $mdata = array(
            "amount"       => $nominal,
            // "currency"      => in_array($currency, ['usdt', 'usdc']) ? $currency . '.bep20' : $currency,
            "currency" => match (strtolower($currency)) {
                'usdt' => COINPAYMENTS_CURRENCY_USDT,
                'usdc' => COINPAYMENTS_CURRENCY_USDC,
                default => $currency,
            },
            "buyer_email"   => $email,
            "description"   => $description ?: 'One To One Payment',
            "invoiceNumber" => $CreateInvoiceNumber->encode(1, 2, 3)
        );

        switch ($currency) {
            case 'usdt':
                $paymentResponse = $this->createCoinPaymentTransaction($mdata);
                if ($paymentResponse['error'] !== 'ok') {
                    session()->setFlashdata('failed', 'There was a problem processing your purchase please try again. Error: ' . $paymentResponse['error']);
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }
                // dd($paymentResponse);
                $paymentlink = $paymentResponse['result']['checkout_url'];
                $invoiceID = $mdata['invoiceNumber'];
                $amount = $mdata['amount'] . ' ' . strtoupper($currency);
                $timeoutInResultSecond = $paymentResponse['result']['timeout'];
                $paymenttimeout = date('Y-m-d H:i:s', time() + $timeoutInResultSecond);

                // Save invoice to API
                $invoiceResponse = $this->saveInvoiceToApi($mdata['buyer_email'], $paymentlink, $invoiceID);
                if (!$invoiceResponse) {
                    session()->setFlashdata('failed', 'Failed to save invoice to API' . $invoiceResponse);
                    // dd($invoiceResponse, $mdata['buyer_email'], $paymentlink, $invoiceID);
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }

                // Kirim email setelah sukses semuanya
                $resultSendEmail = $this->sendpayment($mdata['buyer_email'], $paymentlink, $invoiceID, $amount, $paymenttimeout);
                if (!$resultSendEmail) {
                    log_message('error', 'Gagal mengirim email ke ' . $mdata['buyer_email']);
                }

                // Set flashdata for payment link
                session()->setFlashdata('paymentlink', $paymentResponse['result']['checkout_url']);
                session()->setFlashdata('payment_email', $mdata['buyer_email']);
                session()->setFlashdata('success', 'Payment link created successfully and sent to ' . $mdata['buyer_email']);
                session()->setFlashdata([
                    'paymentlink'    => $paymentResponse['result']['checkout_url'],
                    'payment_email'  => $mdata['buyer_email'],
                    'success'        => 'Payment link created successfully and sent to ' . $mdata['buyer_email']
                ]);

                return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
            case 'usdc':
                $paymentResponse = $this->createCoinPaymentTransaction($mdata);
                if ($paymentResponse['error'] !== 'ok') {
                    session()->setFlashdata('failed', 'There was a problem processing your purchase please try again. Error: ' . $paymentResponse['error']);
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }
                // dd($paymentResponse);
                $paymentlink = $paymentResponse['result']['checkout_url'];
                $invoiceID = $mdata['invoiceNumber'];
                $amount = $mdata['amount'] . ' ' . strtoupper($currency);
                $timeoutInResultSecond = $paymentResponse['result']['timeout'];
                $paymenttimeout = date('Y-m-d H:i:s', time() + $timeoutInResultSecond);

                // Save invoice to API
                $invoiceResponse = $this->saveInvoiceToApi($mdata['buyer_email'], $paymentlink, $invoiceID);
                if (!$invoiceResponse) {
                    session()->setFlashdata('failed', 'Failed to save invoice to API' . $invoiceResponse);
                    // dd($invoiceResponse, $mdata['buyer_email'], $paymentlink, $invoiceID);
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }

                // Kirim email setelah sukses semuanya
                $resultSendEmail = $this->sendpayment($mdata['buyer_email'], $paymentlink, $invoiceID, $amount, $paymenttimeout);
                if (!$resultSendEmail) {
                    log_message('error', 'Gagal mengirim email ke ' . $mdata['buyer_email']);
                }

                // Set flashdata for payment link
                session()->setFlashdata('paymentlink', $paymentResponse['result']['checkout_url']);
                session()->setFlashdata('payment_email', $mdata['buyer_email']);
                session()->setFlashdata('success', 'Payment link created successfully and sent to ' . $mdata['buyer_email']);
                session()->setFlashdata([
                    'paymentlink'    => $paymentResponse['result']['checkout_url'],
                    'payment_email'  => $mdata['buyer_email'],
                    'success'        => 'Payment link created successfully and sent to ' . $mdata['buyer_email']
                ]);

                return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
            case 'stripe':
                $amount = $mdata['amount'] . ' ' . strtoupper($currency);
                $stripeUrl = $this->createStripePayment($mdata);
                if (!$stripeUrl) {
                    return redirect()->to(base_url('godmode/onetoone/payment'))->withInput();
                }
                dd($stripeUrl);

                // Kirim email setelah link berhasil dibuat
                $this->sendpayment($mdata['buyer_email'], $stripeUrl);

                session()->setFlashdata('payment_email', $mdata['buyer_email']);
                session()->setFlashdata('paymentlink', $stripeUrl);
                session()->setFlashdata('success', 'Payment link created successfully');
                return redirect()->to(BASE_URL .  'godmode/onetoone/payment')->withInput();
            case 'banktransfer':
                session()->setFlashdata('paymentlink', 123);
                return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
        }
    }

    function createCoinPaymentTransaction($mdata)
    {
        $publicKey  = COINPAYMENTS_PUBLIC_KEY;
        $privateKey = COINPAYMENTS_PRIVATE_KEY;
        $url = COINPAYMENTS_API_URL; // use actual API URL
        $nonce = get_coinpayments_nonce();

        $payload = [
            'cmd'        => 'create_transaction',
            'amount'     => $mdata['amount'],
            'currency1'  => 'USD',
            'currency2'  => strtoupper($mdata['currency']),
            'invoice'    => $mdata['invoiceNumber'],
            'buyer_email' => $mdata['buyer_email'],
            'item_name'  => $mdata['description'],
            'key'        => $publicKey,
            //NOTE : Pastikan ipn_url bisa diakses oleh CoinPayments
            'ipn_url'    => base_url() . 'godmode/auth/coinpayment_notify',
            // 'ipn_url'    => ' https://6ad122f05350.ngrok-free.app/godmode/auth/coinpayment_notify',
            'success_url' => base_url() . 'godmode/onetoone/payment',
            'cancel_url' => base_url() . 'godmode/onetoone/payment',
            'version'    => 1,
            'format'     => 'json',
            'nonce'       => $nonce
        ];

        $postData = http_build_query($payload, '', '&');
        $hmac = hash_hmac('sha512', $postData, $privateKey);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $hmac]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    public function createStripePayment($mdata)
    {
        \Stripe\Stripe::setApiKey(SECRET_KEY);

        try {
            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'], // atau ['card', 'us_bank_account', etc]
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $mdata['description'],
                        ],
                        'unit_amount' => intval(floatval($mdata['amount']) * 100), // dalam sen. Misal €10 = 1000
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $mdata['buyer_email'],
                'invoice_creation' => ['enabled' => true],
                'success_url' => base_url() . 'course/login/member',
                'cancel_url' => base_url() . 'course/login/member'
            ]);
            $paymentResponse = [
                'result' => [
                    'checkout_url' => $checkoutSession->url,
                    'txn_id' => $checkoutSession->id,
                    'timeout' => $checkoutSession->expires_at,
                    'amount' => $mdata['amount']
                ],
                'error' => 'ok'
            ];
            return $paymentResponse;
        } catch (\Exception $e) {
            session()->setFlashdata('failed', 'Stripe error: ' . $e->getMessage());
            return null;
        }
    }

    private function saveInvoiceToApi($email, $link_invoice, $invoiceID)
    {
        $client = \Config\Services::curlrequest(); // CI HTTP Client

        $payload = [
            'email'         => $email,
            'status_invoice' => "unpaid",
            'link_invoice'  => $link_invoice,
            'invoice_number'    => $invoiceID,
            'invoice_date'  => date('Y-m-d H:i:s')
        ];

        try {
            $url = URL_HEDGEFUND . '/apiv1/onetoone/payment';
            $response = $client->post($url, [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $result = $response->getBody();
            log_message('info', 'Invoice API response: ' . $result);

            return json_decode($result, true);
        } catch (\Exception $e) {
            log_message('error', 'Error saving invoice: ' . $e->getMessage());
            return null;
        }
    }

    public function sendpayment($email, $paymentlink, $invoiceID, $amount, $paymenttimeout)
    {
        $title         = 'Payment Request';
        $subject       = 'Please Complete Your Payment';
        $emailTemplate = emailtemplate_payment_onetoone($paymentlink, $amount, $paymenttimeout, $invoiceID);

        return sendmail_onetoone($email, $subject, $emailTemplate, $title, 'no-reply@pnglobalinternational.com');
    }

    public function sendpaymentstatus($email, $invoiceID)
    {
        $title         = 'Payment Status Success';
        $subject       = 'Your Payment Status';
        $emailTemplate = emailtemplate_paymentstatus_onetoone($invoiceID);

        return sendmail_onetoone($email, $subject, $emailTemplate, $title, 'no-reply@pnglobalinternational.com');
    }
}