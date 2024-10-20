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


    public function service()
    {
        $service = base64_decode($_GET['service']);
        
        if($service == "finance_advice_investment"){
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_finance',
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
            'email'         => $newEmail,
            'subject'       => htmlspecialchars($this->request->getVar('subject'))
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
        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY); 
        $paymentMethodId = $_POST['payment_method_id'];
        $amount = 15000; // Replace with the actual amount in cents (e.g., $50.00 = 5000)
        $currency = 'usd'; // Replace with your desired currency
    
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

                    // Create Google Calendar
                    $calendarId = 'primary'; // Your calendar ID
                    $slot = explode("#", $_SESSION['client']['datetime']);
                    $slotStart = $slot[0];
                    $slotEnd = $slot[1];
        
                    $eventName = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];
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
                        $subject = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];
        
        
                        // Assign SESSION client
                        $mdata = $_SESSION['client'];
                        sendmail_booking($subject, $mdata);
            
                    } catch (\RuntimeException $e) {
                        session()->setFlashdata('failed', 'Failed to booking schedule: '. $e->getMessage());
                        header("Location: ". BASE_URL . 'homepage/bookingconsultation');
                        exit();
                    }
        
                }
            }
        }catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: '. $e->getError()->message);
            header("Location: ". BASE_URL . 'homepage/bookingconsultation');
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

        if($step == 'second_step' || $step == 'third_step'){
            $mdata = [
                'title'     => 'Account Deletion - ' . NAMETITLE,
                'content'   => 'homepage/account_deletion',
                'extra'     => 'homepage/js/_js_account_deletion',
                'step'      => $step
            ];
        }else{
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
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/account_deletion?step='.base64_encode('second_step'))->withInput();
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


}
