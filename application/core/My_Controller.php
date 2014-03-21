<?php

/**
* @file My_Controller.php
* @synopsis  核心控制器重写
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 14:46:29
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
	public $db;
	protected $flauth = 'flystm!';
	protected $command = '';
	public $recvdata = null;
	public $params = null;
	public $user_id = null;
	public $uid = null;
	public $coopid = '';
	public $pid = '';
	public $softversion = '';
	public $imei = '';
	public $macaddress = '';
	public $istest = False;

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',true);
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->__init__();
	}

	private function __init__()
	{
		$this->myuri = $this->uri->rsegments;
		$this->command = implode($this->myuri,'/');

		$istest = $this->input->get('test');
		$this->istest = $istest ? True : False;
		$this->dorecvdata();
		
		if(!$this->istest)
		{
			if(!$this->recvdata)
			{	
				$this->echodata(0,'','对不起，未接收到数据','-1');
			}
		}

		$this->params = $this->recvdata['commandInfo'];
		$this->uid = $this->recvdata['serviceInfo']['uid'];
		$this->user_id = $this->recvdata['properties']['uuid'];
		$this->coopid = $this->recvdata['clientInfo']['subCoopId'];
		$this->pid = $this->recvdata['clientInfo']['productId'];
		$this->softversion = $this->recvdata['clientInfo']['editionId'];
		$this->imei = $this->recvdata['mobileInfo']['imei'];
	}

	private function dorecvdata()
	{
		$this->load->helper('fllogs');
		$get_data = file_get_contents('php://input', 'r');
		if(!$get_data)
		{
			$this->recvdata = null;
			if(!$this->istest)
			{
				@lwlog($get_data);
			}
		}else
		{
			$getdata = dordata($get_data);
			@lwlog($getdata);
			$this->recvdata = $getdata ? $getdata : null;
		}
	}

	public function echodata($issucced = 1,$response = array(),$tips = 'succeed',$code = '0')
	{
		$responsedata = $issucced ? bwtitle($this->command, $tips) : errbwtitle($this->command, $response,$code,$tips);
		($issucced && $response) && $responsedata = array_merge($responsedata,$response);
		if($this->istest)
		{
			debug($responsedata);
		}
		$data = dopdata($responsedata);
		echo $this->flauth . $data;
		exit(0);
	}

}

