<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Date: 7/19/21
 * Time: 9:46 AM
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require  SYSTEM_PATH . 'config/mailer/src/Exception.php';
require SYSTEM_PATH . 'config/mailer/src/PHPMailer.php';
require SYSTEM_PATH . 'config/mailer/src/SMTP.php';

class Mail extends PHPMailer {
    /*
     * Receiver
     */
    public $_to;
    public $_subject;
    public $_from;
    public $_message;

    function __construct() {
        parent::__construct();
    }

    function php_send() {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From:". $this->from . "\r\n";
        try {
            mail($this->to, $this->subject, $this->message, $headers);
        }
        catch(Exception $e){

        };
    }
}