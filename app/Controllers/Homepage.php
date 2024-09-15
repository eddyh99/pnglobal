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
        $mdata = [
            'title'     => 'Booking Consultant - ' . NAMETITLE,
            'content'   => 'homepage/contact/bookingconsultation',
            'extra'     => 'homepage/contact/js/_js_bookingconsultation'
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
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/bookingconsultation')->withInput();
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
            'content'   => 'homepage/contact/summary_booking',
            'extra'     => 'homepage/contact/js/_js_summary_booking'
        ];

        return view('homepage/layout/wrapper-contactus', $views);

    }

    public function booking_proccess()
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

            $eventName = NAMETITLE . ' - Booking Consultation';
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
                $subject = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['fname'];

                // Assign SESSION client
                $mdata = $_SESSION['client'];

                sendmail_booking($subject, $mdata);
    
            } catch (\RuntimeException $e) {
                session()->setFlashdata('failed', 'Failed to booking schedule: '. $e->getMessage());
                header("Location: ". BASE_URL . 'homepage/bookingconsultation');
                exit();
            }

        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: '. $e->getError()->message);
            header("Location: ". BASE_URL . 'homepage/bookingconsultation');
            exit();
        }
    }

    // Contact Form Normaly
    public function contactform()
    {
        $mdata = [
            'title'     => 'Contact Form - ' . NAMETITLE,
            'content'   => 'homepage/contact/contactform',
            'extra'     => 'homepage/contact/js/_js_contactform'
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

        ]);

        // Checking Validation
        if(!$rules){
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

        // Subject
        $subject = NAMETITLE . ' - Contact Form ' . $mdata['fname'];

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
            // 'instagram'  => [
            //     'label'     => 'Instagram',
            //     'rules'     => 'valid_url'
            // ],
            // 'tiktok'  => [
            //     'label'     => 'Tiktok',
            //     'rules'     => 'valid_url'
            // ],
            // 'fprofile'  => [
            //     'label'     => 'Facebook Profile',
            //     'rules'     => 'valid_url'
            // ],
            // 'fgroup'  => [
            //     'label'     => 'Facebook Group',
            //     'rules'     => 'valid_url'
            // ],
            // 'fpage'  => [
            //     'label'     => 'Facebook Page',
            //     'rules'     => 'valid_url'
            // ],
            // 'linkedin'  => [
            //     'label'     => 'Linkedin',
            //     'rules'     => 'valid_url'
            // ],
            // 'discord'  => [
            //     'label'     => 'Discord',
            //     'rules'     => 'valid_url'
            // ],
            'identity'      => [
                'label'     => 'Identity',
                'rules'     => 'uploaded[identity]|max_size[identity,20000]|mime_in[identity,application/pdf]'
            ],

        ]);

        // Checking Validation
        if(!$rules){
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


}
