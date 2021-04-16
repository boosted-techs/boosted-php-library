<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 2020-09-22
 * Time: 12:39
 */

class Home extends Controller
{
    function __construct()
    {
    }

    function index() {
        $this->smarty->display("index.tpl");
    }

    function welcome() {
        echo "we are here";
    }

}