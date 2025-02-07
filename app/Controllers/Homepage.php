<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\GoogleCalendarService;
use DateTime;
use DateTimeZone;

class Homepage extends BaseController
{
    protected $googleCalendarService;

    public function __construct()
    {
        $this->googleCalendarService = new GoogleCalendarService();
    }

    public function index()
    {

        $mdata = [
            'title'     => 'Homepage - ' . NAMETITLE,
            'content'   => 'homepage/index',
            'extra'     => 'homepage/js/_js_index',
            'extragsap' => 'homepage/gsap/gsap_homepage',
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function about()
    {
        $mdata = [
            'title'     => 'About Team - ' . NAMETITLE,
            'content'   => 'homepage/about',
            'extra'     => 'homepage/js/_js_about',
            'extragsap' => 'homepage/gsap/gsap_about'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function comingsoon()
    {
        $mdata = [
            'title'     => 'Coming Soon - ' . NAMETITLE,
            'content'   => 'homepage/comingsoon',
            'extra'     => 'homepage/js/_js_index',
            'flag'      => 'comingsoon'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }



    public function service()
    {
        $service = base64_decode($_GET['service']);

        // if ($service == "finance_advice_investment") {
        //     $mdata = [
        //         'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
        //         'content'   => 'homepage/service/finance',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_finance',
        //     ];
        // } else if ($service == "strategic_optimization") {
        //     $mdata = [
        //         'title'     => 'Service Strategic And Tax Optimization - ' . NAMETITLE,
        //         'content'   => 'homepage/service/strategic',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_strategic'
        //     ];
        // } else if ($service == "international_expansion_management") {
        //     $mdata = [
        //         'title'     => 'Service International Expansion And Management - ' . NAMETITLE,
        //         'content'   => 'homepage/service/international',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_international'
        //     ];
        // } else if ($service == "legal_tax_accounting") {
        //     $mdata = [
        //         'title'     => 'Legal, Tax, And Accounting Advice - ' . NAMETITLE,
        //         'content'   => 'homepage/service/legal',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_legal'
        //     ];
        // } else if ($service == "professional_enterpreneurial_training") {
        //     $mdata = [
        //         'title'     => 'Service Professional Enterpreneurial Training - ' . NAMETITLE,
        //         'content'   => 'homepage/service/training',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_training',
        //         'flag'      => 'blockchain'
        //     ];
        // } else if ($service == "blockchain_mining_bitcoin_training") {
        //     $mdata = [
        //         'title'     => 'Advanced Training on Blockchain, Mining and Bitcoin - ' . NAMETITLE,
        //         'content'   => 'homepage/service/blockchain',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_blockchain',
        //         'flag'      => 'blockchain'
        //     ];
        // } else if ($service == "satoshi_signal") {
        //     $mdata = [
        //         'title'     => 'Bitcoin Trading Guidance for Buy/Sell Decisions - ' . NAMETITLE,
        //         'content'   => 'homepage/service/satoshi',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_satoshi',
        //         'flag'      => 'satoshi'
        //     ];
        // } else if ($service == "lux_btc_brokers") {
        //     $mdata = [
        //         'title'     => 'Lux BTC Brokers - ' . NAMETITLE,
        //         'content'   => 'homepage/service/lux_btc_brokers',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_luxbtc',
        //         'flag'      => 'luxbtc'
        //     ];
        // } else if ($service == "btc_elite_management") {
        //     $mdata = [
        //         'title'     => 'BTC Elite Management - ' . NAMETITLE,
        //         'content'   => 'homepage/service/btc_elite_management',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_btc_elite_management',
        //         'flag'      => 'btcelitemanagement'
        //     ];
        // } else {
        //     $mdata = [
        //         'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
        //         'content'   => 'homepage/service/finance',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_finance'
        //     ];
        // }

        if ($service == "satoshi_signal") {
            $mdata = [
                'title'     => 'Satoshi Signal - ' . NAMETITLE,
                'content'   => 'homepage/service/satoshi_signal',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_satoshi_signal',
                'flag'      => 'satoshisignal'
            ];
        } else if ($service == "lux_btc_brokers") {
            $mdata = [
                'title'     => 'Lux BTC Brokers - ' . NAMETITLE,
                'content'   => 'homepage/service/lux_btc_brokers',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_luxbtc',
                'flag'      => 'luxbtc'
            ];
        } else if ($service == "btc_elite_management") {
            $mdata = [
                'title'     => 'BTC Elite Management - ' . NAMETITLE,
                'content'   => 'homepage/service/btc_elite_management',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_btc_elite_management',
                'flag'      => 'btcelitemanagement'
            ];
        } else if ($service == "crypto_consulting") {
            $mdata = [
                'title'     => 'Crypto Consulting - ' . NAMETITLE,
                'content'   => 'homepage/service/crypto_consulting',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_crypto_consulting',
                'flag'      => 'cryptoconsulting'
            ];
        } else if ($service == "passive_income") {
            $mdata = [
                'title'     => 'Passive Income - ' . NAMETITLE,
                'content'   => 'homepage/service/passive_income',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_passive_income',
                'flag'      => 'passiveincome',
                'darkNav'   => true
            ];
        } else if ($service == "portfolio_creation") {
            $mdata = [
                'title'     => 'Portfolio Creation - ' . NAMETITLE,
                'content'   => 'homepage/service/portfolio_creation',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_portfolio_creation',
                'flag'      => 'portfolio'
            ];
        } else if ($service == "accumulation_plan") {
            $mdata = [
                'title'     => 'Accumulation Plan - ' . NAMETITLE,
                'content'   => 'homepage/service/accumulation_plan',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_accumulation_plan',
                'flag'      => 'accumulation',
                'darkNav'   => true
            ];
        } else if ($service == "funds_reallocation") {
            $mdata = [
                'title'     => 'Funds Reallocation - ' . NAMETITLE,
                'content'   => 'homepage/service/funds_reallocation',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_funds_reallocation',
                'flag'      => 'funds',
                'darkNav'   => true
            ];
        } else if ($service == "wealth_consulting") {
            $mdata = [
                'title'     => 'Wealth Consulting - ' . NAMETITLE,
                'content'   => 'homepage/service/wealth_consulting',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_wealth_consulting',
                'flag'      => 'wealth'
            ];
        } else {
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_finance'
            ];
        }
        return view('homepage/layout/wrapper', $mdata);
    }


    public function satoshi_price()
    {
        $mdata = [
            'title'     => 'Price - ' . NAMETITLE,
            'content'   => 'homepage/service/satoshi-price',
            'extra'     => 'homepage/service/js/_js_satoshi_price',
            'navoption' => true,
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function register_process()
    {
        // Validation Field
        $rules = $this->validate([
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'pass'     => [
                'label'     => 'Password',
                'rules'     => 'required|min_length[8]'
            ],
            'cpass'     => [
                'label'     => 'Confirm Password',
                'rules'     => 'required|matches[pass]|min_length[8]'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/satoshi_price#register')->withInput();
        }

        // Initial Data
        $mdata = [
            'email'         => htmlspecialchars($this->request->getVar('email')),
            'password'      => sha1(htmlspecialchars($this->request->getVar('pass'))),
            'ipaddress'      => htmlspecialchars($this->request->getIPAddress()),
        ];

        $reff = trim(htmlspecialchars($this->request->getVar('reff')));

        // Call Endpoin Check Referral
        $urlReff = URLAPI . "/v1/member/get_byreferral?refcode=" . $reff;
        $isValidReff = satoshiAdmin($urlReff)->result;

        if ($isValidReff->code != "200" && $reff != "") {
            session()->setFlashdata('failed', $isValidReff->message);
            return redirect()->to(BASE_URL . 'homepage/satoshi_price#register')->withInput();
        }

        $mdata['referral'] = empty($reff) ? null : $reff;
        // Call Endpoin Register
        $url = URLAPI . "/auth/register";
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'homepage/satoshi_price#register')->withInput();
        } else {
            $subject = "Activation Account - " . SATOSHITITLE;
            sendmail_satoshi($mdata['email'], $subject,  emailtemplate_activation_account($result->message->token, $mdata['email']));
            return redirect()->to(BASE_URL . 'homepage/satoshi_active_account/' . base64_encode($mdata['email']));
        }
    }

    public function satoshi_active_account($email)
    {
        $email = base64_decode($email);

        // Call Endpoin Get Member By Email
        $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
        $result = satoshiAdmin($url)->result;

        if ($result->message->status == "active" && $result->message->membership == "expired") {
            return redirect()->to(BASE_URL . 'homepage/satoshi_register_payment/' . base64_encode($email));
        }

        $mdata = [
            'title'     => 'Active Account - ' . NAMETITLE,
            'content'   => 'homepage/service/satoshi-otp',
            'extra'     => 'homepage/service/js/_js_satoshi_otp',
            'navoption' => true,
            'emailuser' => $email
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function satoshi_check_otp()
    {
        // Validation Field
        $rules = $this->validate([
            'first'     => [
                'label'     => 'First Column',
                'rules'     => 'required'
            ],
            'second'     => [
                'label'     => 'Second Column',
                'rules'     => 'required'
            ],
            'third'     => [
                'label'     => 'Third Column',
                'rules'     => 'required'
            ],
            'fourth'     => [
                'label'     => 'Fourth Column',
                'rules'     => 'required'
            ],
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            echo json_encode(["code" => "500", "message" => $this->validation->listErrors()]);
            exit();
        }

        $first = htmlspecialchars($this->request->getVar('first'));
        $second = htmlspecialchars($this->request->getVar('second'));
        $third = htmlspecialchars($this->request->getVar('third'));
        $fourth = htmlspecialchars($this->request->getVar('fourth'));

        $mdata = [
            "otp"   => $first . $second . $third . $fourth,
            "email" => htmlspecialchars($this->request->getVar('email'))
        ];

        // Call Endpoin Activation Account
        $url = URLAPI . "/auth/activate?token=" . $mdata['otp'] . "&email=" . $mdata['email'];
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        echo json_encode($result);
    }

    public function satoshi_register_payment($email)
    {
        $email = base64_decode($email);
        // Call Endpoin Get Member By Email
        $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
        $result = satoshiAdmin($url)->result->message;

        $price = [
            "1m"    => 250,
            "3m"    => 600,
            "6m"    => 1050,
            "1y"    => 1800
        ];

        $selisihReferral = [
            "1m"    => 25,
            "3m"    => 75,
            "6m"    => 150,
            "1y"    => 300
        ];

        $mdata = [
            'title'     => 'Active Account - ' . NAMETITLE,
            'content'   => 'homepage/service/satoshi-payment',
            'extra'     => 'homepage/service/js/_js_satoshi_payment',
            'navoption' => true,
            'member'    => $result,
            'price'     => $price,
            'disc'      => $selisihReferral
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function satoshi_register_process($email)
    {
        $email = base64_decode($email);
        // Call Endpoin Get Member By Email
        $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
        $result = satoshiAdmin($url)->result->message;

        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY);
        $paymentMethodId = $_POST['payment_method_id'];

        $getprice = htmlspecialchars($this->request->getVar('price'));
        $currency = 'eur';
        $mdata = [
            "email" => $result->email,
            "referral"  => $result->id_referral
        ];

        if (!empty($result->id_referral)) {
            $discount = [
                "1m"    => 25,
                "3m"    => 75,
                "6m"    => 150,
                "1y"    => 300
            ];
        } else {
            $discount = [
                "1m"    => 0,
                "3m"    => 0,
                "6m"    => 0,
                "1y"    => 0
            ];
        }



        if ($getprice == 250) {
            $mdata['amount'] = $getprice - $discount['1m'];
            $mdata['period'] = 30;
        } else if ($getprice == 600) {
            $mdata['amount'] = $getprice - $discount['3m'];
            $mdata['period'] = 30 * 3;
        } else if ($getprice == 1050) {
            $mdata['amount'] = $getprice - $discount['6m'];
            $mdata['period'] = 30 * 6;
        } else if ($getprice == 1800) {
            $mdata['amount'] = $getprice - $discount['1y'];
            $mdata['period'] = 365;
        } else {
            session()->setFlashdata('failed', "Invalid Amount, Please Try Again");
            return redirect()->to(BASE_URL . 'homepage/satoshi_register_payment/' .  base64_encode($result->email));
        }


        try {

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $mdata['amount'],
                'currency' => $currency,
                'payment_method' => $paymentMethodId,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // Disable redirect-based payment methods
                ],
            ]);

            if ($paymentIntent->status === 'requires_confirmation') {
                $confirmedPaymentIntent = $paymentIntent->confirm();

                // If the payment was successful, proceed with creating the calendar event
                if ($confirmedPaymentIntent->status === 'succeeded') {
                    // POST subscribe member
                    $url = URLAPI . "/v1/subscription/paidsubscribe";
                    $result = satoshiAdmin($url, json_encode($mdata))->result->message;

                    session()->setFlashdata('successPayment', 'Thank you for your register, wait 1-5 minutes our team will be contact');
                    header("Location: " . BASE_URL . "homepage/service?service=" . base64_encode("satoshi_signal"));
                    exit();
                }
            }
        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: ' . $e->getError()->message);
            header("Location: " . BASE_URL . 'homepage/satoshi_register_payment/' .  base64_encode($result->email));
            exit();
        }
    }

    public function contact_success()
    {
        $mdata = [
            'title'     => 'Contact Success - ' . NAMETITLE,
            'content'   => 'homepage/contact/contact_success',

        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    // Contact Booking Consultant
    public function bookingconsultation()
    {

        $service = base64_decode($_GET['service']);
        $service = explode('-', $service);
        $subject = $service[0];

        $mdata = [
            'title'     => 'Booking Consultant - ' . NAMETITLE,
            'content'   => 'homepage/contact/bookingconsultation',
            'extra'     => 'homepage/contact/js/_js_bookingconsultation',
            'subject'   => $subject
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }


    public function getSlots()
    {
        // $calendarId = 'pnglobal.usa@gmail.com';
        $calendarId = 'primary';
        $userTimeZone = $this->request->getPost('timezone');

        $availableSlots = $this->googleCalendarService->getSlotsNextDay($calendarId, $userTimeZone);

        $mdata = [
            "slot"  => $availableSlots,
            "timezone"  => $userTimeZone
        ];
        echo json_encode($mdata);
        die;
    }

    public function booking_summary()
    {

        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'trim|required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'trim|required'
            ],
            'email.*'   => [
                'label'     => 'Email',
                'rules'     => 'trim|valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'trim|required'
            ],
            'desc'      => [
                'label'     => 'Description',
                'rules'     => 'trim|required'
            ],
            'timezone'      => [
                'label'     => 'Timezone',
                'rules'     => 'trim|required'
            ],
            'schedule'      => [
                'label'     => 'Schedule',
                'rules'     => 'trim|required'
            ],
            'subject'      => [
                'label'     => 'Subject',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/bookingconsultation')->withInput();
        }

        // Filter EMAIL
        $email = $this->request->getVar('email');
        $newEmail = array();
        foreach ($email as $dt) {
            array_push($newEmail, filter_var($dt, FILTER_VALIDATE_EMAIL));
        }

        $tempreferral = trim(htmlspecialchars($this->request->getVar('referral')));
        $_SESSION["referral"] = null;
        $referral = null;
        if (!empty($tempreferral)) {
            // Call API
            $url = URLAPI . "/v1/member/get_byreferral?refcode=" . $tempreferral;
            $resultReff = satoshiAdmin($url)->result;


            $referral = ($resultReff->code == 200) ? $tempreferral : null;
            $_SESSION["referral"] = ($resultReff->code == 200) ? $resultReff->message->id : null;
        }

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'datetime'      => htmlspecialchars($this->request->getVar('schedule')),
            'timezone'      =>  htmlspecialchars($this->request->getVar('timezone')),
            'description'   => htmlspecialchars($this->request->getVar('desc')),
            'email'         => $newEmail,
            'subject'       => htmlspecialchars($this->request->getVar('subject')),
            'referral'      => $referral
        ];


        $this->session->set('client', $mdata);

        $views = [
            'title'     => 'Summary - ' . NAMETITLE,
            'content'   => 'homepage/contact/summary_booking',
            'extra'     => 'homepage/contact/js/_js_summary_booking',
            'data'      => $mdata
        ];

        return view('homepage/layout/wrapper-contactus', $views);
    }

    public function booking_proccess()
    {
        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY);
        $paymentMethodId = $_POST['payment_method_id'];
        if (!empty($_SESSION["referral"])) {
            $amount = 25000; // Replace with the actual amount in cents (e.g., $50.00 = 5000)
        } else {
            $amount = 35000;
        }
        $currency = 'eur'; // Replace with your desired currency

        try {
            // Create a PaymentIntent with the payment method ID
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method' => $paymentMethodId,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // Disable redirect-based payment methods
                ],
            ]);

            if ($paymentIntent->status === 'requires_confirmation') {
                $confirmedPaymentIntent = $paymentIntent->confirm();

                // If the payment was successful, proceed with creating the calendar event
                if ($confirmedPaymentIntent->status === 'succeeded') {
                    // Call API

                    $mdata = array(
                        "email"     => $_SESSION['client']['email'][0],
                        "amount"    => $amount / 100,
                        "referral"  => empty($_SESSION["referral"]) ? null : $_SESSION["referral"]
                    );
                    $url = URLAPI . "/auth/bookconsultation";
                    $resultReff = satoshiAdmin($url, json_encode($mdata))->result;

                    // Create Google Calendar
                    $calendarId = 'primary'; // Your calendar ID
                    $slot = explode("#", $_SESSION['client']['datetime']);
                    $slotStart = $slot[0];
                    $slotEnd = $slot[1];

                    $eventName = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];
                    $timezone = $_SESSION['client']['timezone'];
                    $description = '<div>
                                        <p>Fullname: ' . $_SESSION['client']['fname']  . ' ' . $_SESSION['client']['lname'] . '</p>
                                        <p>Whatsapp: ' . $_SESSION['client']['whatsapp'] . '</p>
                                        <p>Email: ' . $_SESSION['client']['email'][0] . '</p>
                                        <p>' . $_SESSION['client']['description'] . '</p>
                                    </div>';

                    // Parse and format slot times back to RFC3339 for event creation
                    $slotStartDT = DateTime::createFromFormat('d-m-Y H:i:s', $slotStart, new DateTimeZone($timezone));
                    $slotEndDT = DateTime::createFromFormat('d-m-Y H:i:s', $slotEnd, new DateTimeZone($timezone));

                    $eventData = [
                        'summary' => $eventName,
                        'description' => $description,
                        'start' => [
                            'dateTime' => $slotStartDT->format(DateTime::RFC3339),
                            'timeZone' => $timezone,
                        ],
                        'end' => [
                            'dateTime' => $slotEndDT->format(DateTime::RFC3339),
                            'timeZone' => $timezone,
                        ],
                    ];

                    try {
                        //$this->googleCalendarService->createEvent($calendarId, $eventData);

                        // Subject
                        $subject = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];


                        // Assign SESSION client
                        $mdata = $_SESSION['client'];
                        //sendmail_booking($subject, $mdata);

                    } catch (\RuntimeException $e) {
                        session()->setFlashdata('failed', 'Failed to booking schedule: ' . $e->getMessage());
                        header("Location: " . BASE_URL . 'homepage/bookingconsultation');
                        exit();
                    }
                }
            }
        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: ' . $e->getError()->message);
            header("Location: " . BASE_URL . 'homepage/bookingconsultation');
            exit();
        }
    }

    // Contact Form Normaly
    public function contactform()
    {

        $service = base64_decode($_GET['service']);
        $service = explode('-', $service);
        $subject = $service[0];

        $mdata = [
            'title'     => 'Contact Form - ' . NAMETITLE,
            'content'   => 'homepage/contact/contactform',
            'extra'     => 'homepage/contact/js/_js_contactform',
            'subject'   => $subject
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function contactform_proccess()
    {
        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'required'
            ],
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'required'
            ],
            'desc'      => [
                'label'     => 'Description',
                'rules'     => 'required'
            ],
            'subject'      => [
                'label'     => 'Subject',
                'rules'     => 'required'
            ],

        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/contactform')->withInput();
        }

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'description'   => htmlspecialchars($this->request->getVar('desc')),
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL)
        ];

        $tempSubject = htmlspecialchars($this->request->getVar('subject'));

        // Subject
        $subject = NAMETITLE . ' - Contact Form ' . $tempSubject . ' | ' . $mdata['fname'];

        sendmail_contactform($subject, $mdata);
    }

    // Contact Form for Get Referral
    public function contactreferral()
    {
        $mdata = [
            'title'     => 'Contact Form Referral- ' . NAMETITLE,
            'content'   => 'homepage/contact/contactreferral',
            'extra'     => 'homepage/contact/js/_js_contactreferral'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function contactreferral_proccess()
    {
        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'required'
            ],
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'required'
            ],
            'mtongue'  => [
                'label'     => 'Mother Tongoue',
                'rules'     => 'required'
            ],
            'language'  => [
                'label'     => 'Language',
                'rules'     => 'required'
            ],
            'country'  => [
                'label'     => 'Country',
                'rules'     => 'required'
            ],
            'identity'      => [
                'label'     => 'Identity',
                'rules'     => 'uploaded[identity]|max_size[identity,20000]|mime_in[identity,application/pdf]'
            ],

        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/contactreferral')->withInput();
        }

        // Get File PDF
        $filePDF = $this->request->getFile('identity');
        $filePath = $filePDF->getTempName();
        $fileName = $filePDF->getClientName();

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL),
            'instagram'     => htmlspecialchars($this->request->getVar('instagram')),
            'tiktok'        => htmlspecialchars($this->request->getVar('tiktok')),
            'fprofile'      => htmlspecialchars($this->request->getVar('fprofile')),
            'fgroup'        => htmlspecialchars($this->request->getVar('fgroup')),
            'fpage'         => htmlspecialchars($this->request->getVar('fpage')),
            'linkedin'      => htmlspecialchars($this->request->getVar('linkedin')),
            'discord'       => htmlspecialchars($this->request->getVar('discord')),
        ];

        // Subject
        $subject = NAMETITLE . ' - Request Referral ' . $mdata['fname'];

        sendmail_referral($subject, $mdata, $filePath, $fileName);
    }

    public function connection()
    {
        $mdata = [
            'title'     => 'Connections - ' . NAMETITLE,
            'content'   => 'homepage/connection',
            'extra'     => 'homepage/js/_js_index',
            'extragsap' => 'homepage/gsap/gsap_finance'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function privacy_policy()
    {
        $mdata = [
            'title'     => 'Privacy Policy - ' . NAMETITLE,
            'content'   => 'homepage/privacy_policy',
            'extra'     => 'homepage/js/_js_privacy_policy',
            'flag'      => 'privacy'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function terms_conditions()
    {
        $mdata = [
            'title'     => 'Privacy Policy - ' . NAMETITLE,
            'content'   => 'homepage/terms_conditions',
            'extra'     => 'homepage/js/_js_privacy_policy',
            'flag'      => 'terms'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function account_deletion()
    {
        $step = base64_decode(@$_GET['step']);

        if ($step == 'second_step' || $step == 'third_step') {
            $mdata = [
                'title'     => 'Account Deletion - ' . NAMETITLE,
                'content'   => 'homepage/account_deletion',
                'extra'     => 'homepage/js/_js_account_deletion',
                'step'      => $step
            ];
        } else {
            $mdata = [
                'title'     => 'Account Deletion - ' . NAMETITLE,
                'content'   => 'homepage/account_deletion',
                'extra'     => 'homepage/js/_js_account_deletion',
                'step'      => 'first_step'
            ];
        }


        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function account_deletion_proccess()
    {

        // Validation Field
        $rules = $this->validate([
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'reason'      => [
                'label'     => 'Reason',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/account_deletion?step=' . base64_encode('second_step'))->withInput();
        }

        // Initial Data
        $mdata = [
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL),
            'reason'        => htmlspecialchars($this->request->getVar('reason')),
        ];

        // Subject
        $subject = NAMETITLE . ' - Account Deletion ' . $mdata['email'];
        sendmail_accountdel($subject, $mdata);
    }

    public function training_course()
    {
        $mdata = [
            'title'     => 'Training Courses - ' . NAMETITLE,
            'content'   => 'homepage/training_course',
            'extra'     => 'homepage/js/_js_training_course',
            'extragsap' => 'homepage/gsap/gsap_training_course',
        ];

        return view('homepage/layout/wrapper', $mdata);
    }
}
