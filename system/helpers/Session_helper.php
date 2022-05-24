<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Company: Boosted Technologies LTD
 * Date: 7/19/21
 * Time: 9:44 AM
 */

class Session
{
    public $data;
    public $_session_id;
    function __construct()
    {
        $this->data = (object)$this->session_data();
        $this->_session_id = session_id();
    }

    private function session_data() {
        return  $_SESSION;
    }

    function set_user_data($session, $data) {
        $_SESSION[$session] = $data;
        //session_write_close();
    }

    function data($session) {
        if (empty(trim($session)))
            return $_SESSION;
        if (isset ($_SESSION[$session]))
            return $_SESSION[$session];
        else
            return false;
    }

    function remove_data($session) {
        if (isset($_SESSION[$session]))
            unset($_SESSION[$session]);
        return true;
    }

    function destroy() {
        session_unset();
        session_destroy();
    }

    function regenerate_session() {
        session_regenerate_id();
        session_write_close();
    }
}