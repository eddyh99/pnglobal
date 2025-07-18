<?php

namespace App\Controllers\Godmode\Onetoone;

use App\Controllers\BaseController;
use App\Models\MemberOnetoOneModel;
use Config\Services;

class Payment extends BaseController
{
    public function index()
    {
        // Fetching all members for the dropdown
        $urlListMember = URL_HEDGEFUND . "/apiv1/onetoone/member/";
        $resultMember = satoshiAdmin($urlListMember)->result;
        if ($resultMember->code != 200) {
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

        $mdata = array(
            "amount"       => $nominal,
            "currency"      => in_array($currency, ['usdt', 'usdc']) ? $currency . '.bep20' : $currency,
            "buyer_email"   => $email,
            "description"   => $description ?: 'One To One Payment',
            "invoiceNumber" => 'INV-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 6))
        );

        switch ($currency) {
            case 'usdt':
            case 'usdc':
                $paymentResponse = $this->createCoinPaymentTransaction($mdata);
                if ($paymentResponse['error'] !== 'ok') {
                    session()->setFlashdata('failed', 'There was a problem processing your purchase please try again');
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }
                $checkoutUrl = $paymentResponse['result']['checkout_url'];

                // Save invoice to API
                $invoiceResponse = $this->saveInvoiceToApi($mdata['buyer_email'], $checkoutUrl);
                if (!$invoiceResponse) {
                    session()->setFlashdata('failed', 'Failed to save invoice to API');
                    return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
                }
                // Set flashdata for payment link
                session()->setFlashdata('paymentlink', $paymentResponse['result']['checkout_url']);
                session()->setFlashdata('payment_email', $mdata['buyer_email']);
                session()->setFlashdata('success', 'Payment link created successfully');
                return redirect()->to(BASE_URL . 'godmode/onetoone/payment')->withInput();
            case 'stripe':
                $stripeUrl = $this->createStripePayment($mdata);
                if (!$stripeUrl) {
                    return redirect()->to(base_url('godmode/onetoone/payment'))->withInput();
                }

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
            'ipn_url'    => base_url() . 'course/auth/coinpayment_notify',
            'success_url' => base_url() . 'course/login/member',
            'cancel_url' => base_url() . 'course/login/member',
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
        log_message('error', "COIN PAYMENT" . json_encode($response));
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

            return $checkoutSession->url;
        } catch (\Exception $e) {
            session()->setFlashdata('failed', 'Stripe error: ' . $e->getMessage());
            return null;
        }
    }

    public function sendpayment()
    {
        // Validation Field
        $rules = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            'paymentlink' => [
                'label' => 'Payment Link',
                'rules' => 'required'
            ],
        ]);

        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/dashboard');
        }
        $email = $this->request->getVar('email');
        $title = 'Payment Request';
        $subject = 'Please Complete Your Payment';

        // send email
        $emailTemplate = emailtemplate_payment_course($this->request->getVar('paymentlink'));
        sendmail_satoshi($email, $subject, $emailTemplate, $title, USERNAME_MAIL);

        session()->setFlashdata('success', 'Payment link has been sent successfully to ' . $email . '.');
        return redirect()->to(BASE_URL . 'godmode/course/dashboard')->withInput();
    }

    private function saveInvoiceToApi($email, $link_invoice)
    {
        $client = \Config\Services::curlrequest(); // CI HTTP Client

        $payload = [
            'email'         => $email,
            'status_invoice'=> "unpaid",
            'link_invoice'  => $link_invoice,
            'invoice_date'  => date('Y-m-d H:i:s'),
        ];

        try {
            $response = $client->post('http://localhost:8080/apiv1/onetoone/payment/', [
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
}
