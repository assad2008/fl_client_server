<?php

/**
* @file makebw.php
* @synopsis  报文处理相关函数
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 14:19:44
*/

	define('CRYPTKEY',0x0000000);

	function bwtitle($command,$tips = 'succeed')
	{
		$bwtitle = array
		(
    	'protocol' => '1.2.0',
    	'command' => $command,
    	'protocolType' => 'reply',
			'result' => array('code' => '0','tips' => $tips),	
		);
		return $bwtitle;
	}

	function errbwtitle($command,$type = 1,$code = '-1', $tips = 'unknown')
	{
		$bw = array 
		(
    	'protocol' => '1.2.0',
    	'command' => $command,
    	'protocolType' => 'reply',
  		'result' => array()
		);
		switch($type)
		{
			case 1:
				$bw['result'] = array('code' => '-1','tips' => 'command error');
				break;
			case 2:
				$bw['result'] = array('code' => '-2','tips' => 'no input data');
				break;			
			case 3:
				$bw['result'] = array('code' => '-3','tips' => 'data error');
				break;
			case 4:
				$bw['result'] = array('code' => '-4','tips' => 'database error');
				break;
			default:
				$bw['result'] = array('code' => $code,'tips' => $tips);
		}
		return $bw;
	}

	function DE($str)
	{
		$str = str2asc($str);
		$data = array();
		foreach($str AS $k=>$v)
		{
			$data[$k] = $v ^ CRYPTKEY;
		}
		$str = asc2str($data);
		return $str;
	}


	function str2asc($str)
	{
		$data = array();
		$lenth = strlen($str);
		for($i = 0;$i < $lenth;$i++)
		{
			$data[$i] = ord($str[$i]);
		}
		return $data;
	}

	function asc2str($str)
	{
		$data = '';
		foreach($str AS $v)
		{
			$data .= chr($v);
		}
		return $data;
	}

	function dopdata($data)
	{
		$result = '';
		$result = json_encode($data);  //转为josn格式
		$result = gzcompress($result);  //进行压缩
		$result = DE($result);  //加密
		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}

	function dordata($data)
	{
		$rdata = DE($data);  //解密
		$rdata = gzuncompress($rdata); //解压缩  $rdata JSON格式
		$rdata = json_decode($rdata,1);  //为数组;
		if($rdata)
		{
			return $rdata;
		}else
		{
			return false;
		}
	}

