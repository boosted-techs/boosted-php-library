<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 1/7/22
 * Time: 10:16 AM
 */
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}

class Security_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_user_preferences($username) {
        return json_decode($this->redis->hGet(self::REDIS_SECURITY_OPTIONS, $username));
    }

    function update_user_preferences($user): bool
    {

        $security_object = (object)array();
        $security_object->_2f = trim($this->inputs->post("_2f")) === "true";
        $security_object->_logOut= trim($this->inputs->post("_logOut")) === "true";
        $security_object->_otp = trim($this->inputs->post("_otp")) === "true";
        $security_object->_mute = trim($this->inputs->post("_mute")) === "true";
        $security_object->_funds = trim($this->inputs->post("_funds")) === "true";

        $user->security_options = json_encode($security_object);

        $this->redis->hSet(self::REDIS_SECURITY_OPTIONS, $user->username, json_encode($security_object));
        $this->redis->hSet(self::REDIS_USER_PROFILE, $user->username, json_encode($user));
        $this->db->where("user", $user->user);
        return $this->db->update("basic_info", array("security_options" => json_encode($security_object)));

    }

}