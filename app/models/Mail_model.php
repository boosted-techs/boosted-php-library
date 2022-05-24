<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 2020-08-22
 * Time: 20:03
 */
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Mail_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function send_mail($email, $message, $subject) {
        //Mail
        $this->mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = 'boostedtechs.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = 'no-reply@boostedtechs.com';                 // SMTP username
        $this->mail->Password = '~po,YM]*5@f]';                           // SMTP password
        $this->mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 465;

        $this->mail->setFrom('no-reply@boostedtechs.com', 'Paullah');
        // $mail->addAddress('ashrikan@gmail.com', 'Ashan');     // Add a recipient
        $this->mail->addAddress($email);               // Name is optional
        // $mail->addReplyTo($reply, 'Reply too');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $this->mail->isHTML(true);                                  // Set email format to HTML
        $this->mail->Subject = $subject;
        $this->mail->Body    = $message;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();
        $this->mail->clearAllRecipients();
    }
}