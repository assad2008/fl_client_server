fl_client_server
================

B/S架构中的S

提供给客户端的数据后端服务,基于CI改造

加密解密已经完成。控制器/方法为Command


|$this->params|客户端传的commandInfo|
|$this->user_id |uuid|
|$this->uid | uid|
|$this->pid | 产品ID|
|$this->softversion| 版本号|
|$this->coopid|渠道号|

### 日志

/data/logs/,cilogs目录为CI的Log目录。lwlogs目录为联网日志,rplogs为打印数据的一个日志目录

### 示例：

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
	
如果需要在浏览器进行调试

则访问：http://xxxx/welcome/test?`test=1`

则会显示出：

	Array
	(
		[protocol] => 1.2.0
		[command] => welcome/index
		[protocolType] => reply
		[result] => Array
			(
				[code] => 0
				[tips] => succeed
			)

		[List] => Array
			(
				[Do] => This is a test
			)

	)

