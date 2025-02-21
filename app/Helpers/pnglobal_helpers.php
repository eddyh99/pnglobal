<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function satoshiAdmin($url, $postData = NULL)
{
    $token = sha1($_SESSION["logged_user"]->email . $_SESSION["logged_user"]->passwd);

    $ch     = curl_init($url);
    $headers    = array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    if (!is_null($postData)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    $result = (object) array(
        'result'        => json_decode(curl_exec($ch)),
        'status'        => curl_getinfo($ch)['http_code']
    );
    curl_close($ch);
    return $result;
}


function sendmail_booking($subject, $mdata)
{
    $mail = new PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host         = HOST_MAIL;
        $mail->SMTPAuth     = true;
        $mail->Username     = USERNAME_MAIL;
        $mail->Password     = PASS_MAIL;
        $mail->SMTPAutoTLS  = true;
        $mail->SMTPSecure   = "ssl";
        $mail->Port         = 465;
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

        if (!$mail->send()) {

            session()->setFlashdata('failed', 'Failed send email, please try again!');
            header("Location: " . BASE_URL . 'homepage/bookingconsultation');
            exit();
        } else {

            $mail->isSMTP();
            $mail->Host         = HOST_MAIL;
            $mail->SMTPAuth     = true;
            $mail->Username     = USERNAME_MAIL;
            $mail->Password     = PASS_MAIL;
            $mail->SMTPAutoTLS  = true;
            $mail->SMTPSecure   = "ssl";
            $mail->Port         = 465;
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

            if (!$mail->send()) {
                session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
                header("Location: " . BASE_URL . 'homepage/bookingconsultation');
                exit();
            } else {
                session()->setFlashdata('success', 'Schedule booked successfully');
                header("Location: " . BASE_URL . 'homepage/contact_success');
                exit();
            }
        }
    } catch (Exception $e) {
        session()->setFlashdata('failed', 'Failed schedule booked, please try again!');
        header("Location: " . BASE_URL . 'homepage/bookingconsultation');
        exit();
    }
}


function sendmail_satoshi($email, $subject, $message)
{
    $mail = new PHPMailer();
    try {
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

        $mail->SMTPDebug = 2;

        $mail->setFrom(USERNAME_MAIL, SATOSHITITLE . ' Activation Email');
        $mail->isHTML(true);
        $mail->ClearAllRecipients();
        $mail->Subject = $subject;
        $mail->AddAddress($email);
        $mail->msgHTML($message);
        $mail->send();
    } catch (Exception $e) {
        exit();
    }
}



function sendmail_contactform($subject, $mdata)
{
    $mail = new PHPMailer();

    try {
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
        $mail->AddAddress(EMAIL_TWO);


        $template = emailtemplate_regular($mdata);
        $mail->msgHTML($template);

        if (!$mail->send()) {
            session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
            header("Location: " . BASE_URL . 'homepage/contactform');
            exit();
        } else {
            session()->setFlashdata('success', 'Message successfully send');
            header("Location: " . BASE_URL . 'homepage/contact_success');
            exit();
        }
    } catch (Exception $e) {
        session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
        header("Location: " . BASE_URL . 'homepage/contactform');
        exit();
    }
}

function sendmail_referral($subject, $mdata, $attachmentPath = null, $attachmentName = null)
{
    $mail = new PHPMailer();

    try {
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
        $mail->AddAddress(EMAIL_TWO);

        // Attachments
        if (!empty($attachmentPath)) {
            $mail->addAttachment($attachmentPath, $attachmentName); // Add PDF from temporary path
        }

        $template = emailtemplate_referral($mdata);
        $mail->msgHTML($template);

        if (!$mail->send()) {
            session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
            header("Location: " . BASE_URL . 'homepage/contactreferral');
            exit();
        } else {
            session()->setFlashdata('success', 'Message successfully send');
            header("Location: " . BASE_URL . 'homepage/contact_success');
            exit();
        }
    } catch (Exception $e) {
        session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
        header("Location: " . BASE_URL . 'homepage/contactreferral');
        exit();
    }
}


function sendmail_accountdel($subject, $mdata)
{
    $mail = new PHPMailer();

    try {
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

        $mail->setFrom(USERNAME_MAIL, NAMETITLE . ' Account Deletion');
        $mail->addReplyTo($mdata['email']);
        $mail->isHTML(true);
        $mail->ClearAllRecipients();
        $mail->Subject = $subject;
        $mail->AddAddress(EMAIL_ONE);
        $mail->AddAddress(EMAIL_TWO);


        $template = emailtemplate_accountdel($mdata);
        $mail->msgHTML($template);

        if (!$mail->send()) {
            session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
            header("Location: " . BASE_URL . 'homepage/account_deletion?step=' . base64_encode('second_step'));
            exit();
        } else {
            session()->setFlashdata('success', 'Message successfully send');
            header("Location: " . BASE_URL . 'homepage/account_deletion?step=' . base64_encode('third_step'));
            exit();
        }
    } catch (Exception $e) {
        session()->setFlashdata('failed', 'Failed Send Message, Please Try Again!');
        header("Location: " . BASE_URL . 'homepage/account_deletion?step=' . base64_encode('second_step'));
        exit();
    }
}
