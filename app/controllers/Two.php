<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 2020-09-22
 * Time: 15:30
 */

class Two extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Home_model");
    }

    function index() {
        $this->model->Home_model->home();
        $this->smarty->assign("test", "anything");
        $this->smarty->assign("array", array(array("greet" => "hello", "b" => 4)));
        $this->smarty->display("test.tpl");
    }
}