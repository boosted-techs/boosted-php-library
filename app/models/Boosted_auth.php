<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 11/8/21
 * Time: 10:10 PM
 */

use JetBrains\PhpStorm\ArrayShape;

if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Boosted_auth extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function validate_session($key, $active_domain) {
        $url = $active_domain['auth']."/verify_session";
        $data = array("key" => $key, "app" => 5);
        return $this->make_Request($url, $data);
    }

    function make_Request($url, $post_data = null, $get_params = null, $headers = false): bool|string
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        #do this if the request is post
        if(!empty($post_data)){
            $postFields = json_encode($post_data);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

            // Set HTTP Header for POST request
            curl_setopt($curl, CURLOPT_HTTPHEADER, ! $headers ? array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postFields)) : $headers
            );

            curl_setopt($curl, CURLOPT_URL, $url);
        }
        #do this if its a get request with params
        if(!empty($get_params)){
            $url = $url . '?' . http_build_query($get_params);
            curl_setopt($curl, CURLOPT_URL, $url);
        }
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    function create_pagination($search_results): array
    {
        $page = empty ($this->input_get("page")) ? 0 : $this->input_get("page");
        $pagination = array();
        if ($search_results > 0) {
            $number_of_pages = ceil($search_results / 10) - 1;
            //Variable range from active holds the number of tabs to be inserted between the active tab and the tab with dots eg 1(active),2,3,4,5,6,...
            $range_from_active  = 5;
            $left_page = $page - 1;
            $right_page = $page + $range_from_active + 1;
            $replace_with_dots = array();
            $lowest_limit = -1;
            for ($a=0; $a<=$number_of_pages; $a++) {
                if ($a == 0 || $a == $number_of_pages || $a >= $left_page && $a < $right_page) {
                    $replace_with_dots[] = $a;
                }
            }
            for ($i = 0; $i< count($replace_with_dots); $i++) {
                if ($lowest_limit != -1){
                    if ($replace_with_dots[$i] - $lowest_limit === 2){
                        $pagination[] = $lowest_limit + 1;
                    }
                    else if ($replace_with_dots[$i] - $lowest_limit !== 1) {
                        $pagination[] = '...';
                    }
                }
                $pagination[] = $replace_with_dots[$i];
                $lowest_limit = $replace_with_dots[$i];
            }
        }
        return $pagination;
    }

    #[ArrayShape(["auth" => "string", "redirect" => "string"])] function get_active_domain(): array
    {
        $protocol = getenv('HTTPS') ? 'https://' : 'http://';
        return array("auth" => "https://www.auth.boostedtechs.com", "redirect" => $protocol . $_SERVER['HTTP_HOST']);
    }
}