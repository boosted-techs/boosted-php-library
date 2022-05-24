<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 1/13/22
 * Time: 11:14 AM
 */

use JetBrains\PhpStorm\NoReturn;

if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Currencies_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function _get_accepted_currencies(): object
    {
        return (object)$this->gdb_redis->zRange(self::CURRENCIES_ACCEPTED, 0, -1);

    }

    function _add_accepted_currencies(): array
    {
        $code = $this->security->xss_clean(trim($this->inputs->post("code")));
        $currency = $this->security->xss_clean(trim($this->inputs->post("currency")));
        if (empty ($code) or empty($currency))
            return array("code" => 403,  "status" => "error", "title" => "Error", "message" => "Could not perform action");

        $r = $this->gdb_redis->zAdd(self::CURRENCIES_ACCEPTED, time(), $currency);
        if ($r)
            $this->gdb_redis->hSet(self::COUNTRY_CURRENCY, (int)$code, $currency);
        return $r ? array("code" => 200,  "status" => "success", "title" => "Success", "message" => "Successfully added currency")
            :
            array("code" => 403, "status" => "error", "title" => "Error", "message" => "Record exits");
    }
    function get_currency_by_country_code($code): bool|string
    {
        return $this->gdb_redis->hGet(self::COUNTRY_CURRENCY, $code);;
    }

    function get_currency_rate($base_currency) {
        return json_decode($this->gdb_redis->hGet(self::CURRENCY_RATES, $base_currency));
    }

}