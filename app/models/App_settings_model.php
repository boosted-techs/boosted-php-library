<?php

class App_settings_model extends Model
{
    function __construct() {
        parent::__construct();
    }

    function _get_app_version() {
        return json_decode($this->redis->get(APP_VERSION));
    }

    function _set_app_version($user) {
        $id = $this->db->insert("app_updates", array("user" => $user));
        $this->redis->set(APP_VERSION,
            json_encode(
                ["user" => $user, "id" => $id, "_timestamp" => date("Y-m-d H:i:s")]
            ));
    }

}