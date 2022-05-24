<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Date: 7/19/21
 * Time: 9:34 AM
 */

/*
 * This class works with Post and Get inputs
 */

class Input {
    /*
     * Making it to access object of POST or GET array
     */
    public $post;
    public $get;
    function __construct() {
        $this->post = (object)$this->post_data();
        $this->get = (object)$this->get_data();
    }

    private function get_data() {
        return $_GET;
    }

    private function post_data() {
        return $_POST;
    }

    function post($string = '') {
        $string = trim($string);
        if (empty($string))
            return $_POST;
        if (isset($_POST[$string]))
            return $_POST[$string];
        else
            return false;
    }

    function get($string = '') {
        $string = trim($string);
        if (empty($string))
            return $_GET;
        if (isset($_GET[$string]))
            return $_GET[$string];
        else
            return false;
    }
}