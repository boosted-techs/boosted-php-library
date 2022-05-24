<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 7/19/21
 * Time: 12:07 PM
 */

class Security
{
    public function __construct()
    {
    }
    function xss_clean($string) {
        /*
         * Return cleaned string
         */
        return filter_var(strip_tags($string), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    }

    function validate_email($email): bool
    {
        /*
        *
         * Remove all illegal characters from email
        */
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        /*
         * Validate email
         */
        return ! filter_var($email, FILTER_VALIDATE_EMAIL) === false;
    }

    function validate_ip_address($ip): bool
    {
        return !filter_var($ip, FILTER_VALIDATE_IP) === false;
    }

    function validate_url($url) {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}