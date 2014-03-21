<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $this->echodata(1,array('List' => array('Do' => 'This is a test')));
    }
}

