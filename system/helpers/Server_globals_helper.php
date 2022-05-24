<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Date: 7/19/21
 * Time: 9:49 AM
 */
class Server {
    public $remote_address;
    public $server_name;
    public $request_method;
    public $query_string;
    public $request_uri;
    public $document_root;
    public $http_refer;
    public $server_address;
    public $os;
    function __construct()
    {
        $this->remote_address = $this->remote_addr();
        $this->server_name = $this->server_name();
        $this->request_method = $this->request_method();
        $this->query_string = $this->query_string();
        $this->request_uri = $this->request_uri();
        $this->document_root = $this->document_root();
        $this->http_refer = $this->http_referer();
        $this->server_address = $this->addr();
        $this->os = $this->getOS();
    }
    private function request_method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function query_string() {
        return $_SERVER['QUERY_STRING'];
    }

    private function request_uri() {
        return $_SERVER['REQUEST_URI'];
    }

    private function document_root() {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    private function server_name() {
        return $_SERVER['SERVER_NAME'];
    }

    private function http_referer() {
        if (isset($_SERVER['HTTP_REFERER']))
            return $_SERVER['HTTP_REFERER'];
        else return $this->server_name();
    }

    private function addr() {
        return $_SERVER['SERVER_ADDR'];
    }

    private function remote_addr() {
        return $_SERVER['REMOTE_ADDR'];
    }

    private function getOS() {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
        return $os_platform;
    }
}