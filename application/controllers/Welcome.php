<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->echodata($this->recvdata);
	}
}
