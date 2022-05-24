<?php
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
/*
 * Path to the routing system of BOOSTED PHP LIBRARY
*/
include_once(SYSTEM_PATH . "config/routes.php");
/*
 * Database configuration files for Redis and Mysql Dal
 *
*/
include_once ("database.config.php");

/*
 * Add the Smarty templating Engine for our project
 *
*/

/*
 * Lets add the controller class
 */

require_once "Controller_class.php";

/*
 * Model class
 */

require_once "Model_class.php";

/*
 * System default helper classes
 */
require_once SYSTEM_PATH . "system_helpers.php";

const SYS_DIR = "views/smarty-3.1.34/libs/";
/*
 * Smarty class path
 *
*/
require_once (APP_PATH . SYS_DIR . "Smarty.class.php");
