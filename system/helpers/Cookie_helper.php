<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Company: Boosted Technologies
 * Date: 7/19/21
 * Time: 9:51 AM
 */

class Cookies  {
    public $cookie;
    function __construct()
    {
        //parent::__construct();
        $this->cookie = (object)$this->get_cookie();
    }

    private function get_cookie() {
        return $_COOKIE;
    }
    function set($cookie_name, $cookie_data, $expiry = (86400 * 30 * 3), $path = "/", $domain = "boosted-payment.com", $secure = false, $http_only = true, $samesite = "strict") {
        setcookie($cookie_name, $cookie_data, time() + $expiry, $path, $domain, $secure, $http_only);
    }

    function read($cookie_name = false) {
        if (isset($cookie_name))
            return $_COOKIE[$cookie_name] ?? false;
        return $_COOKIE;

    }

    function destroy($cookie = false) {
        $params = session_get_cookie_params();
        if ($cookie)
            setcookie(
                $cookie,
                " " ,
                time()- 60,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"],
                );
        else {
            //print_r($_SERVER);
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                //print_r($cookies);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie(
                        $name,
                        " " ,
                        time()- 60,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"],
                        );
                }
            }
        }
    }
}