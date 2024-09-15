<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function satoshiAdmin($url, $postData = NULL){
    $token = "ecd1889dfa6fbedfc3ea12f7cf09ee920a95bea5";
    
    $ch     = curl_init($url);
    $headers    = array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    
    $result = (object) array(
        'result'        => json_decode(curl_exec($ch)),
        'status'        => curl_getinfo($ch)['http_code']
    );
    curl_close($ch);
    return $result;
}


function sendmail_booking($subject, $mdata){
    $mail = new PHPMailer();

    try{
        $mail->isSMTP();
        $mail->Host         = HOST_MAIL;
        $mail->SMTPAuth     = true;
        $mail->Username     = USERNAME_MAIL;
        $mail->Password     = PASS_MAIL;
        $mail->SMTPAutoTLS  = true;
        $mail->SMTPSecure   = "tls";
        $mail->Port         = 587;
        // $mail->SMTPDebug    = 2;
        $mail->SMTPOptions = array(
            'ssl'   => array(
                'verify_peer'           => false,
                'verify_peer_name'      => false,
                'allow_self_signed'     => false,
            )
        );

        $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Booking Consultation');
        $mail->addReplyTo(EMAIL_ONE);
        $mail->isHTML(true);

        $mail->ClearAllRecipients();
    
        $mail->Subject = $subject;
        $mail->AddAddress($mdata['email'][0]);
        $template = emailtemplate_client($mdata);

        $mail->msgHTML($template);

        if(!$mail->send()){
            
            session()->setFlashdata('failed', 'Failed send email, please try again!');
            header("Location: ". BASE_URL . 'homepage/bookingconsultation' );
            exit();

        } else {

            $mail->isSMTP();
            $mail->Host         = HOST_MAIL;
            $mail->SMTPAuth     = true;
            $mail->Username     = USERNAME_MAIL;
            $mail->Password     = PASS_MAIL;
            $mail->SMTPAutoTLS  = true;
            $mail->SMTPSecure   = "tls";
            $mail->Port         = 587;
            // $mail->SMTPDebug    = 2;
            $mail->SMTPOptions = array(
                'ssl'   => array(
                    'verify_peer'           => false,
                    'verify_peer_name'      => false,
                    'allow_self_signed'     => false,
                )
            );
    
            $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Booking Consultation');
            $mail->addReplyTo($mdata['email'][0]);
            $mail->isHTML(true);
    
            $mail->ClearAllRecipients();
        
            $mail->Subject = $subject;
            $mail->AddAddress(EMAIL_ONE);
            $mail->AddAddress(EMAIL_TWO);
            
            $template = emailtemplate_owner($mdata);

            $mail->msgHTML($template);

            if(!$mail->send()){
                session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
                header("Location: ". BASE_URL . 'homepage/bookingconsultation');
                exit();
            } else {
                session()->setFlashdata('success', 'Schedule booked successfully');
                header("Location: ". BASE_URL . 'homepage/contact_success');
                exit();
            }
        }

    } catch (Exception $e){
        session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
        header("Location: ". BASE_URL . 'homepage/bookingconsultation');
        exit();
    }
} 

function emailtemplate_client($mdata){
    // Looping email
    $requestemail = '';
    foreach($mdata['email'] as $dt){
        $requestemail .= '<br>' . $dt ;
    }

    // Get Date and Start time
    $datestart = explode('#', $mdata['datetime']);
    $datestart = explode(' ', $datestart[0]);
    
    // Get End time only
    $dateend = explode('#', $mdata['datetime']);
    $dateend = explode(' ', $dateend[1]);

    return "
    <!DOCTYPE html>
        <html lang='en'>

        <head>
            <meta name='color-scheme' content='light'>
            <meta name='supported-color-schemes' content='light'>
            <title>Send Email</title>
        </head>

        <body>
            <div style='max-width: 600px; margin: 0 auto; position: relative; padding: 1rem; background-color: #F7F7F7;'>
                <div style='text-align: center; padding: 3rem;'>
                    <h3 style='font-weight: 600; font-size: 30px; line-height: 45px; color: #000000; margin-bottom: 1rem;text-align: center;'>
                        Hi, ".$mdata['fname']."
                    </h3>
                    <img src='" . BASE_URL . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
                </div>

                <div style='text-align: left; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Thank you for scheduling the meeting. <br>
                        This is to confirm that we have received your payment of ".FEEMEETING." for the scheduled meeting. Please let us know if you have any questions or need further assistance.
                    </p>
                    <p style='font-weight: 400;font-size: 18px;color: #000000;'>
                        Your Summary
                    </p>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        First Name: <span style='font-weight: 800;'>".$mdata['fname']."</span><br>
                        Last Name: <span style='font-weight: 800;'>".$mdata['lname']."</span><br>
                        Whatsapp: <span style='font-weight: 800;'>".$mdata['whatsapp']."</span><br>
                        Email: <span style='font-weight: 800;'>".$requestemail."</span><br>
                        Timezone: <span style='font-weight: 800;'>".$mdata['timezone']."</span><br>
                        Date: <span style='font-weight: 800;'>". $datestart[0]."</span><br>
                        Time: <span style='font-weight: 800;'>". $datestart[1] . ' Until ' . $dateend[1] . "</span><br>
                        Description: <span style='font-weight: 800;'>". $mdata['description'] ."</span><br>
                    </p>
                </div>
                <div style='text-align: center; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Best regards,<br>  
                        ".NAMETITLE." team
                    </p>
                </div>
                <hr>
                <hr>
                <p style='text-align: center;font-weight: 400;font-size: 12px;color: #999999;'>
                    Copyright © " . date('Y') . "
                </p>
            </div>
        </body>
    </html>";
}


function emailtemplate_owner($mdata){
    // Looping email
    $requestemail = '';
    foreach($mdata['email'] as $dt){
        $requestemail .= '<br>' . $dt ;
    }

    // Get Date and Start time
    $datestart = explode('#', $mdata['datetime']);
    $datestart = explode(' ', $datestart[0]);
    
    // Get End time only
    $dateend = explode('#', $mdata['datetime']);
    $dateend = explode(' ', $dateend[1]);

    return "
    <!DOCTYPE html>
        <html lang='en'>

        <head>
            <meta name='color-scheme' content='light'>
            <meta name='supported-color-schemes' content='light'>
            <title>Send Email</title>
        </head>

        <body>
            <div style='max-width: 600px; margin: 0 auto; position: relative; padding: 1rem; background-color: #F7F7F7;'>
                <div style='text-align: center; padding: 3rem;'>
                    <h3 style='font-weight: 600; font-size: 30px; line-height: 45px; color: #000000; margin-bottom: 1rem;text-align: center;'>
                        New Schedule Meeting
                    </h3>
                    <img src='" . BASE_URL . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
                </div>

                <div style='text-align: left; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Thank you for scheduling the meeting. <br>
                        This is to confirm that we have received payment of ".FEEMEETING." for the scheduled meeting.<br>
                        Check your Google Calendar for make sure your schedule is ready.
                    </p>
                    <p style='font-weight: 400;font-size: 18px;color: #000000;'>
                        Summary Client
                    </p>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        First Name: <span style='font-weight: 800;'>".$mdata['fname']."</span><br>
                        Last Name: <span style='font-weight: 800;'>".$mdata['lname']."</span><br>
                        Whatsapp: <span style='font-weight: 800;'>".$mdata['whatsapp']."</span><br>
                        Email: <span style='font-weight: 800;'>".$requestemail."</span><br>
                        Timezone: <span style='font-weight: 800;'>".$mdata['timezone']."</span><br>
                        Date: <span style='font-weight: 800;'>". $datestart[0]."</span><br>
                        Time: <span style='font-weight: 800;'>". $datestart[1] . ' Until ' . $dateend[1] . "</span><br>
                        Description: <span style='font-weight: 800;'>". $mdata['description'] ."</span><br>
                    </p>
                </div>
                <div style='text-align: center; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Best regards,<br>  
                        ".NAMETITLE." team
                    </p>
                </div>
                <hr>
                <hr>
                <p style='text-align: center;font-weight: 400;font-size: 12px;color: #999999;'>
                    Copyright © " . date('Y') . "
                </p>
            </div>
        </body>
    </html>";
}

function sendmail_satoshi($email, $subject, $message){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host         = HOST_MAIL;
    $mail->SMTPAuth     = true;
    $mail->Username     = USERNAME_MAIL;
    $mail->Password     = PASS_MAIL;
    $mail->SMTPAutoTLS  = true;
    $mail->SMTPSecure   = "tls";
    $mail->Port         = 587;
    // $mail->SMTPDebug    = 2;
    $mail->SMTPOptions = array(
        'ssl'   => array(
            'verify_peer'           => false,
            'verify_peer_name'      => false,
            'allow_self_signed'     => false,
        )
    );


    $mail->setFrom(USERNAME_MAIL, NAMETITLE);
    $mail->isHTML(true);

    $mail->ClearAllRecipients();


    $mail->Subject = $subject;
    $mail->AddAddress($email);

    $mail->msgHTML($message);
    $mail->send();
}



function sendmail_contactform($subject, $mdata){
    $mail = new PHPMailer();

    try{
        $mail->isSMTP();
        $mail->Host         = HOST_MAIL;
        $mail->SMTPAuth     = true;
        $mail->Username     = USERNAME_MAIL;
        $mail->Password     = PASS_MAIL;
        $mail->SMTPAutoTLS  = true;
        $mail->SMTPSecure   = "tls";
        $mail->Port         = 587;
        $mail->SMTPOptions = array(
            'ssl'   => array(
                'verify_peer'           => false,
                'verify_peer_name'      => false,
                'allow_self_signed'     => false,
            )
        );

        $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Contact Form');
        $mail->addReplyTo($mdata['email']);
        $mail->isHTML(true);
        $mail->ClearAllRecipients();
        $mail->Subject = $subject;
        $mail->AddAddress(EMAIL_ONE);


        $template = emailtemplate_regular($mdata);
        $mail->msgHTML($template);

        if(!$mail->send()){
            session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
            header("Location: ". BASE_URL . 'homepage/contactform');
            exit();
        } else {
            session()->setFlashdata('success', 'Message successfully send');
            header("Location: ". BASE_URL . 'homepage/contact_success');
            exit();
        }

    } catch (Exception $e){
        session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
        header("Location: ". BASE_URL . 'homepage/contactform');
        exit();
    }
}

function emailtemplate_regular($mdata){

    return "
    <!DOCTYPE html>
        <html lang='en'>

        <head>
            <meta name='color-scheme' content='light'>
            <meta name='supported-color-schemes' content='light'>
            <title>Send Email</title>
        </head>

        <body>
            <div style='max-width: 600px; margin: 0 auto; position: relative; padding: 1rem; background-color: #F7F7F7;'>
                <div style='text-align: center; padding: 3rem;'>
                    <h3 style='font-weight: 600; font-size: 30px; line-height: 45px; color: #000000; margin-bottom: 1rem;text-align: center;'>
                        New email from, ".$mdata['fname']."
                    </h3>
                    <img src='" . BASE_URL . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
                </div>

                <div style='text-align: left; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        First Name: <span style='font-weight: 800;'>".$mdata['fname']."</span><br>
                        Last Name: <span style='font-weight: 800;'>".$mdata['lname']."</span><br>
                        Whatsapp: <span style='font-weight: 800;'>".$mdata['whatsapp']."</span><br>
                        Email: <span style='font-weight: 800;'>".$mdata['email']."</span><br>
                        Description: <span style='font-weight: 800;'>". $mdata['description'] ."</span><br>
                    </p>
                </div>
                <div style='text-align: center; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Best regards,<br>  
                        ".NAMETITLE." team
                    </p>
                </div>
                <hr>
                <hr>
                <p style='text-align: center;font-weight: 400;font-size: 12px;color: #999999;'>
                    Copyright © " . date('Y') . "
                </p>
            </div>
        </body>
    </html>";
}

function sendmail_referral($subject, $mdata, $attachmentPath = null, $attachmentName = null){
    $mail = new PHPMailer();

    try{
        $mail->isSMTP();
        $mail->Host         = HOST_MAIL;
        $mail->SMTPAuth     = true;
        $mail->Username     = USERNAME_MAIL;
        $mail->Password     = PASS_MAIL;
        $mail->SMTPAutoTLS  = true;
        $mail->SMTPSecure   = "tls";
        $mail->Port         = 587;
        $mail->SMTPOptions = array(
            'ssl'   => array(
                'verify_peer'           => false,
                'verify_peer_name'      => false,
                'allow_self_signed'     => false,
            )
        );

        $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Request Referral');
        $mail->addReplyTo($mdata['email']);
        $mail->isHTML(true);
        $mail->ClearAllRecipients();
        $mail->Subject = $subject;
        $mail->AddAddress(EMAIL_ONE);

        // Attachments
        if (!empty($attachmentPath)) {
            $mail->addAttachment($attachmentPath, $attachmentName); // Add PDF from temporary path
        }

        $template = emailtemplate_referral($mdata);
        $mail->msgHTML($template);

        if(!$mail->send()){
            session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
            header("Location: ". BASE_URL . 'homepage/contactreferral');
            exit();
        } else {
            session()->setFlashdata('success', 'Message successfully send');
            header("Location: ". BASE_URL . 'homepage/contact_success');
            exit();
        }

    } catch (Exception $e){
        session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
        header("Location: ". BASE_URL . 'homepage/contactreferral');
        exit();
    }
}

function emailtemplate_referral($mdata){

    return "
    <!DOCTYPE html>
        <html lang='en'>

        <head>
            <meta name='color-scheme' content='light'>
            <meta name='supported-color-schemes' content='light'>
            <title>Send Email</title>
        </head>

        <body>
            <div style='max-width: 600px; margin: 0 auto; position: relative; padding: 1rem; background-color: #F7F7F7;'>
                <div style='text-align: center; padding: 3rem;'>
                    <h3 style='font-weight: 600; font-size: 30px; line-height: 45px; color: #000000; margin-bottom: 1rem;text-align: center;'>
                        New email from, ".$mdata['fname']."
                    </h3>
                    <img src='" . BASE_URL . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
                </div>

                <div style='text-align: left; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        I would like to kindly request my approval for Referral Member at " . NAMETITLE . " <br>
                        Please let me know if you need any further information or clarification in below.
                    </p>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        First Name: <span style='font-weight: 800;'>".$mdata['fname']."</span><br>
                        Last Name: <span style='font-weight: 800;'>".$mdata['lname']."</span><br>
                        Whatsapp: <span style='font-weight: 800;'>".$mdata['whatsapp']."</span><br>
                        Email: <span style='font-weight: 800;'>".$mdata['email']."</span><br>
                        Instagram: <span style='font-weight: 800;'>".@$mdata['instagram']."</span><br>
                        Tiktok: <span style='font-weight: 800;'>".@$mdata['tiktok']."</span><br>
                        Linkedin: <span style='font-weight: 800;'>".@$mdata['linkedin']."</span><br>
                        Discord: <span style='font-weight: 800;'>".@$mdata['discord']."</span><br>
                        Facebook Profile: <span style='font-weight: 800;'>".@$mdata['fprofile']."</span><br>
                        Facebook Group: <span style='font-weight: 800;'>".@$mdata['fgroup']."</span><br>
                        Facebook Page: <span style='font-weight: 800;'>".@$mdata['fpage']."</span><br>
                    </p>
                </div>
                <div style='text-align: center; padding-bottom: 1rem;'>
                    <p style='font-weight: 400;font-size: 14px;color: #000000;'>
                        Best regards,<br>  
                        ".NAMETITLE." team
                    </p>
                </div>
                <hr>
                <hr>
                <p style='text-align: center;font-weight: 400;font-size: 12px;color: #999999;'>
                    Copyright © " . date('Y') . "
                </p>
            </div>
        </body>
    </html>";
}


?>