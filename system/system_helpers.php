<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Date: 7/19/21
 * Time: 11:11 AM
 */


/*
 * Include all the files from the helper folder
 */

define("HELPERS_FOLDER", "helpers/");
$helpers = glob(SYSTEM_PATH . HELPERS_FOLDER . "*.php");

foreach ($helpers as $file)
    require_once $file;
