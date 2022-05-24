<?php

class Home extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index() {
        $this->load_view("home");
    }

}