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
            'extragsap' => 'homepage/gsap/gsap_homepage'
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


    public function service()
    {
        $service = base64_decode($_GET['service']);
        
        if($service == "finance_advice_investment"){
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_finance'
            ];
        }else if($service == "strategic_optimization"){
            $mdata = [
                'title'     => 'Service Strategic And Tax Optimization - ' . NAMETITLE,
                'content'   => 'homepage/service/strategic',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_strategic'
            ];
        }else if($service == "international_expansion_management"){
            $mdata = [
                'title'     => 'Service International Expansion And Management - ' . NAMETITLE,
                'content'   => 'homepage/service/international',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_international'
            ];
        }else if($service == "legal_tax_accounting"){
            $mdata = [
                'title'     => 'Legal, Tax, And Accounting Advice - ' . NAMETITLE,
                'content'   => 'homepage/service/legal',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_legal'
            ];
        }else if($service == "professional_enterpreneurial_training"){
            $mdata = [
                'title'     => 'Service Professional Enterpreneurial Training - ' . NAMETITLE,
                'content'   => 'homepage/service/training',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_training',
                'flag'      => 'training'
            ];
        }else if($service == "blockchain_mining_bitcoin_training"){
            $mdata = [
                'title'     => 'Advanced Training on Blockchain, Mining and Bitcoin - ' . NAMETITLE,
                'content'   => 'homepage/service/blockchain',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_blockchain',
                'flag'      => 'blockchain'
            ];
        }else if($service == "satoshi_signal"){
            $mdata = [
                'title'     => 'Bitcoin Trading Guidance for Buy/Sell Decisions - ' . NAMETITLE,
                'content'   => 'homepage/service/satoshi',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_satoshi',
                'flag'      => 'satoshi'
            ];
        }else{
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_finance'
            ];
        }

        return view('homepage/layout/wrapper', $mdata);

    }


    public function contactus()
    {
        $mdata = [
            'title'     => 'Contact Us - ' . NAMETITLE,
            'content'   => 'homepage/contactus',
            'extra'     => 'homepage/js/_js_contactus'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    
    public function getSlots()
    {
        $calendarId = 'pnglobal.usa@gmail.com';
        $userTimeZone = $this->request->getPost('timezone');

        $availableSlots = $this->googleCalendarService->getSlotsNextDay($calendarId, $userTimeZone);

        $mdata = [
            "slot"  => $availableSlots,
            "timezone"  => $userTimeZone
        ];
        echo json_encode($mdata);
        die;
    }

    public function contactus_summary()
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
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(base_url('homepage/contactus'))->withInput();
        }

        // Filter EMAIL
        $email = $this->request->getVar('email');
        $newEmail = array();
        foreach($email as $dt){
            array_push($newEmail, filter_var($dt, FILTER_VALIDATE_EMAIL));
        }

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'datetime'      => htmlspecialchars($this->request->getVar('schedule')),
            'timezone'      =>  htmlspecialchars($this->request->getVar('timezone')),
            'description'   => htmlspecialchars($this->request->getVar('desc')),
            'email'         => $newEmail
        ];

        $this->session->set('client', $mdata);


        $views = [
            'title'     => 'Summary - ' . NAMETITLE,
            'content'   => 'homepage/summary_contactus',
            'extra'     => 'homepage/js/_js_summary_contactus'
        ];

        return view('homepage/layout/wrapper-contactus', $views);

    }

    

    public function contactus_proccess()
    {

        $token = htmlspecialchars($this->request->getVar('stripeToken'));

        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY); 

        // Proses payment gateway
        try {

            // Insert Charge Stripe
            $charge = \Stripe\Charge::create([
                'amount' => 15000, // Amount in cents ($50.00)
                'currency' => 'eur',
                'description' => $_SESSION['client']['description'],
                'source' => $token,
            ]);

            // Create Google Calendar
            $calendarId = 'primary'; // Your calendar ID
            $slot = explode("#", $_SESSION['client']['datetime']);
            $slotStart = $slot[0];
            $slotEnd = $slot[1];

            $eventName = NAMETITLE . ' - Meeting';
            $timezone = $_SESSION['client']['timezone'];
            $description = '<div>
                                <p>Fullname: '.$_SESSION['client']['fname']  . ' ' . $_SESSION['client']['lname'].'</p>
                                <p>Whatsapp: '.$_SESSION['client']['whatsapp'].'</p>
                                <p>Email: '.$_SESSION['client']['email'][0].'</p>
                                <p>'.$_SESSION['client']['description'].'</p>
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
                $this->googleCalendarService->createEvent($calendarId, $eventData);

                // Subject
                $subject = NAMETITLE . ' - New Meeting';

                // Assign SESSION client
                $mdata = $_SESSION['client'];

                sendmail($subject, $mdata);
    
            } catch (\RuntimeException $e) {
                session()->setFlashdata('failed', 'Failed to book schedule: '. $e->getMessage());
                header("Location: ". base_url('homepage/contactus'));
                exit();
            }

        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: '. $e->getError()->message);
            header("Location: ". base_url('homepage/contactus'));
            exit();
        }


    }

}
