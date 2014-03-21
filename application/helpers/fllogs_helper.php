<?php

/**
* @file fllogs_helper.php
* @synopsis  日志文件
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 18:32:31
*/

	function lwlog($data,$pid = '1299', $t = 'day')  //写联网日志
	{
		global $softwaveid;
		$timestamp = time();
		if($t == 'day')
		{
			$f = date('Ymd',$timestamp);
			switch ($softwaveid) 
			{
				default:
					$filename = BASEDIRS.'data/logs/lwlogs/freemovie.coon.log.'.$f;
					break;
			}
		}

		if($data && is_array($data))
		{
			$logtime = date('Y-m-d H:i:s',$timestamp);
			$options = explode('/',$data['command']);
			list($option,$action) = $options;
			$reqdata = $data['commandInfo'] ? json_encode($data['commandInfo']) : 'null';
			$record = "$logtime - {$data['command']} - {$data['serviceInfo']['uid']} - {$data['clientInfo']['editionId']} - {$data['clientInfo']['subCoopId']} - {$data['clientInfo']['platformId']} - {$data['clientInfo']['productId']} - $reqdata\n";
			writelog($filename, $record, 'ab');
		}else
		{
			$logtime = date('Y-m-d H:i:s',$timestamp);
			$record = "$logtime,data error\n";
			writelog($filename, $record, 'ab');
		}
	}

	function rplog($data,$redata,$sec,$t = 'day')
	{
		$timestamp = time();
		if($t == 'day')
		{
			$f = date('Ymd',$timestamp);
			$filename = BASEDIRS.'data/rplogs/rplog'.$f.'.php';
		}elseif($t == 'month')
		{
			$f = date('Ym',$timestamp);
			$filename = BASEDIRS.'data/rplogs/rplog'.$f.'.php';
		}
		$logtime = date('Y-m-d H:i:s',$timestamp);
		$reqdata = $data['commandInfo'] ? json_encode($data['commandInfo']) : 'null';
		$redata = $redata ? json_encode($redata) : 'null';
		$record = "<?die;?> $logtime - {$data['command']} - $reqdata - $sec - $redata\n";
		writelog($filename, $record, 'ab');	
	}
