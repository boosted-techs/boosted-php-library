<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 2020-07-31
 * Time: 13:50
 */

use JetBrains\PhpStorm\Pure;

if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Auth_model extends Model
{
    public string $security_key;
    function __construct()
    {
        parent::__construct();
        $this->model('Boosted_auth');
        $this->model("Accounts_model");
    }

    function add_security_key()
    {
        $this->security_key = "BOOSTED-TECHS XYZ !!7898788987889 978686757!@#$%^&*((*&^" . date("Y-m-d");
    }

    function active_domain()
    {
        return $this->model->Boosted_auth->get_active_domain();
    }

    function generate_keys()
    {
        $keys = array("bddating", "ashan", "techs", "glosh", "winner", "rin");
        $key = hash("sha256", $keys[array_rand($keys)]);
        //$this->cookie->destroy("local_key");
        if (empty($this->session->data("local_key")))
            $this->session->set_user_data("local_key", $key);
        //echo $this->cookie->read("local_key");
        $this->session->set_user_data("current_page", $this->server->request_uri);
        //echo $this->session->data("current_page"); die();
        return $this->session->data("local_key");
    }

    function save_logs($user, $log, $type = 1)
    {
        $data = array("user" => $user, "log" => $log, "log_type" => $type);
        $this->db->insert("user_logs", $data);
    }

    function save_user_login_tokens($user)
    {
        $token = $this->password_hash(time() . $user . rand(100, 500));
        $this->db->insert("auth", array("user" => $user, "token" => $token));
        $this->cookie->set("auth", $token);
    }

    function delete_session()
    {
        $this->cookie->destroy();
    }

    function is_logged_in(): bool | object
    {
        return empty($this->cookie->cookie->auth) ? false : $this->model->Accounts_model->get_user();
    }

    #[Pure] function create_security_key($string): bool|string
    {
        return $this->password_hash($string . $this->security_key);
    }

    #[Pure] function verify_security_key($string, $key): bool | string
    {
        return strcmp($this->password_hash($string . $this->security_key), $key) == 0 ? $key : false;
    }

    function validate_session($key, $active_domain): bool|string
    {
        $url = $active_domain['auth'] . "/verify_session";
        $data = array("key" => $key, "app" => 6);
        return $this->make_Request($url, $data);
    }

    function make_Request($url, $post_data = null, $get_params = null): bool|string
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        #do this if the request is post
        if (!empty($post_data)) {
            $postFields = json_encode($post_data);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

            // Set HTTP Header for POST request
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postFields))
            );

            curl_setopt($curl, CURLOPT_URL, $url);
        }
        #do this if its a get request with params
        if (!empty($get_params)) {

            $url = $url . '?' . http_build_query($get_params);
            curl_setopt($curl, CURLOPT_URL, $url);
        }
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}