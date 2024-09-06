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


function sendmail($subject, $mdata){
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

        $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Notification');
        $mail->addReplyTo(EMAIL_ONE);
        // $mail->addReplyTo('aripramana574@gmail.com');
        $mail->isHTML(true);

        $mail->ClearAllRecipients();
    
        $mail->Subject = $subject;
        $mail->AddAddress($mdata['email'][0]);
        $template = emailtemplate_client($mdata);

        $mail->msgHTML($template);

        if(!$mail->send()){
            
            session()->setFlashdata('failed', 'Failed send email, please try again!');
            header("Location: ". base_url('homepage/contactus'));
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
    
            $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Notification');
            $mail->addReplyTo($mdata['email'][0]);
            $mail->isHTML(true);
    
            $mail->ClearAllRecipients();
        
            $mail->Subject = $subject;
            $mail->AddAddress(EMAIL_ONE);
            $mail->AddAddress(EMAIL_TWO);
            // $mail->AddAddress('ari.pramana@undiksha.ac.id');
            // $mail->AddAddress('aripramana574@gmail.com');
            
            $template = ownertemplate_client($mdata);

            $mail->msgHTML($template);

            if(!$mail->send()){
                session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
                header("Location: ". base_url('homepage/contactus'));
                exit();
            } else {
                session()->setFlashdata('success', 'Schedule booked successfully');
                header("Location: ". base_url('homepage/contactus'));
                exit();
            }
        }

    } catch (Exception $e){
        session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
        header("Location: ". base_url('homepage/contactus'));
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
                    <img src='" . base_url() . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
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


function ownertemplate_client($mdata){
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
                    <img src='" . base_url() . "assets/img/logo.png' alt='".NAMETITLE."' height='80'>
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

function sendmail_satoshi($email, $subject, $message)
{
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


?>