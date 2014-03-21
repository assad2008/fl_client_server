<?php
/**
* @file error_db.php
* @synopsis  自定义错误 
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 18:26:12
*/


	include(BASEDIRS . 'application/helpers/makebw_helper.php');
	$command = $GLOBALS['URI']->uri_string;
	$data = errbwtitle($command,$type = 4);
	exit('flystm!' . dopdata($data));
