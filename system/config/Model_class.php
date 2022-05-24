<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Company: Boosted Technologies LTD
 * Company Email: office@boostedtechs.com
 * Company Website:https://www.boostedtechs.com
 * Author's webiste: https://www.tumusii.me
 * Date: 7/19/21
 * Time: 9:29 AM
 */
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Model extends Controller {
    const HANDLER = 'redis';

    /**
     *
     * Main Db Handler
     *
     */
    public MysqliDb $db;
    /**
     *
     * Main Redis Handler
     *
     */
    public Redis $redis;
    /*
     *
     * Gateway Handlers for mysql
     *
     */
    function __construct(){
        parent::__construct();
        /**
         * MySqlDb config
         * */
        /*
         *
         * Database for Boosted Gateway Interface
         *
         */
        global $database_config;
        /*
         *
         *
         */
        $this->db = new MysqliDb($database_config['host'], $database_config['username'], $database_config['password'], $database_config['database']);
        /*
         * Database for Payment Gateway
         */


        global $redis_configuration;
        /*
         *
         * Initiate the redis class
         *
         */
        $this->redis = new Redis();
        /**
         * Getting the redis database index to work with. 0 is for the app interface
         */


        /*
         * Make a connection to the database
         *
         *
         */
        $redis_configuration['is_persistent_connection'] == false ? $this->redis->connect($redis_configuration['host'], $redis_configuration['port'])
            :
            $this->redis->pconnect($redis_configuration['host'], $redis_configuration['port']);
        $this->redis->select($redis_configuration['database']);
        /*
         *
         * Pass the redis user and password as an associative array
         *
         */

        $this->redis->auth($redis_configuration['auth']);

        /**
         *
         * Gateway Redis config
         *
         */

        global $redis_gateway_config;
        /*
         *
         * Initiate the redis class
         *
         *
         */

    }

    public function password_hash($string): bool|string
    {

        return hash('sha256', str_replace(" ", "-", $string));
    }

    function is_valid_telephone_number(string $telephone, int $min_digits = 10, int $max_digits = 14): bool {
        if (preg_match('/^[+][0-9]/', $telephone)) { //is the first character + followed by a digit
            $count = 1;
            $telephone = str_replace(['+'], '', $telephone, $count); //remove +
        }

        //remove white space, dots, hyphens and brackets
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

        //are we left with digits only?
        return self::isDigits($telephone, $min_digits, $max_digits);
    }

    function normalise_phone_number(string $telephone): string {
        //remove white space, dots, hyphens and brackets
        return str_replace([' ', '.', '-', '(', ')'], '', $telephone);
    }

    function isDigits(string $s, int $min_digits = 9, int $max_digits = 14): bool {
        return preg_match('/^[0-9]{'.$min_digits.','.$max_digits.'}\z/', $s);
    }
}