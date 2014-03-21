<?php
/**
* @file error_404.php
* @synopsis  重写404
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 14:40:21
*/
	
	include(BASEDIRS . 'application/helpers/makebw_helper.php');
	$command = $GLOBALS['URI']->uri_string;
	$data = errbwtitle($command,$type = 1);
	exit('flystm!' . dopdata($data));
