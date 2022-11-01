<?php
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
/***
 * MySql
 */

/*
 * MyQl username for MySQL DAL
 */
$database_config['host'] = 'localhost';
/*
 * MySql username
 */

$database_config['username'] = 'root';
/*
 * Mysql Password
 */
$database_config['password'] = 'root';
/*
 * Mysql database to work with
 */
$database_config['database'] = 'boosted_apps';

/**
 * Mysql Database config for Payment gateway
 */

/*
 * MyQl username for MySQL DAL
 */
$gateway_DB_config['host'] = 'localhost';
/*
 * MySql username
 */

$gateway_DB_config['username'] = 'root';
/*
 * Mysql Password
 */
$gateway_DB_config['password'] = 'root';
/*
 * Mysql database to work with
 */
$gateway_DB_config['database'] = '';

/**
 * Redis
 */

/*
 * Redis server host
 */
$redis_configuration['host'] = "localhost";
/*
 * Redis username
 */
$redis_configuration['username'] = null;
/*
 * Redis password
 */
$redis_configuration['password'] = null;
//22bab0639b4ee5b84a56c9f5872871864faba575cdb2783354fb2daf6b9e9707

//Default port for redis
$redis_configuration['port'] = 6379;
/*
 * Redis database
 */
$redis_configuration['database'] = 0;
/*
 * Redis key Prefix
 */
$redis_configuration['prefix'] = "_boosted_apps";
/*
 * Persistent connection by default is false
 */
$redis_configuration['is_persistent_connection'] = false;
/*
 * Redis auth
 * This can be username name or password
 * Pass it as array
 */
$redis_configuration['auth'] = null; // array("boosted_apps" => "boosted@99!54%^sdf")
/*
 *
 *
 */

/**
 * Redis Database 2 Configurations for Payment gateway
 */



/*
 * Redis server host
 */
$redis_gateway_config['host'] = "localhost";
/*
 * Redis username
 */
$redis_gateway_config['username'] = null;
/*
 * Redis password
 */
$redis_gateway_config['password'] = null;
//22bab0639b4ee5b84a56c9f5872871864faba575cdb2783354fb2daf6b9e9707

//Default port for redis
$redis_gateway_config['port'] = 6379;
/*
 * Redis database
 */
$redis_gateway_config['database'] = 1;
/*
 * Redis key Prefix
 */
$redis_gateway_config['prefix'] = "_boosted_gateway";
/*
 * Persistent connection by default is false
 */
$redis_gateway_config['is_persistent_connection'] = false;
/*
 * Redis auth
 * This can be username name or password
 * Pass it as array
 */
$redis_gateway_config['auth'] = null; // array("boosted_apps" => "boosted@99!54%^sdf")
/*
 *
 *
 */

