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

    public function service()
    {
        $service = base64_decode($_GET['service']);

        if ($service == "satoshi_signal") {
            $mdata = [
                'title'     => 'Satoshi Signal - ' . NAMETITLE,
                'content'   => 'homepage/service/satoshi_signal',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_satoshi_signal',
                'flag'      => 'satoshisignal'
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

    /* Commented out other functions
    public function about() {...}
    public function comingsoon() {...}
    public function satoshi_active_account() {...}
    public function satoshi_check_otp() {...}
    public function satoshi_register_payment() {...}
    public function satoshi_register_process() {...}
    public function contact_success() {...}
    public function bookingconsultation() {...}
    public function getSlots() {...}
    public function booking_summary() {...}
    public function booking_proccess() {...}
    public function contactform() {...}
    public function contactform_proccess() {...}
    public function contactreferral() {...}
    public function contactreferral_proccess() {...}
    public function connection() {...}
    public function privacy_policy() {...}
    public function terms_conditions() {...}
    public function account_deletion() {...}
    public function account_deletion_proccess() {...}
    public function training_course() {...}
    */
}
