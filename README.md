fl_client_server
================

C/S架构中的S

提供给客户端的数据后端服务,基于CI开发

加密解密已经完成。

### Command

客户端请求数据，使用的是Command

`控制器/方法`为Command

比如：一个协议conmand定义为：`movie/start`

那么必须实现一个`Movie`的`控制器`，再在class中完成start方法。

客户端请求地址为：

	http://url/movie/start

数据调试访问地址：
	
	http://url/movie/start?test=1


### 控制器中的顶级变量

- $this->recvdata为接收到客户端的所有请求数据
- $this->params为客户端传的commandInfo 
- $this->user_id为uuid 
- $this->uid为uid  
- $this->pid为产品ID  
- $this->softversion为版本号  
- $this->coopid为渠道号

### 日志

	/data/logs/

- `cilogs`目录为CI的Log目录  
- `lwlogs`目录为联网日志  
- `rplogs`为打印数据的一个日志目录  

### 业务示例：

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

	
### 调试
	
如果需要在浏览器进行调试

则访问：http://xxxx/welcome/test?`test=1`，拼上?test=1，即为浏览器调试模式

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

### 返回数据

如果正常返回数据：

	$this->echodata(1,array(),'数据成功',0);
	
`echodata`方法的功能是向客户端返回数据

- 第一个参数为：成功或者失败，成功1，失败0  
- 第二个参数为要返回的数据，可以为空，如果不为空，则必须为array  
- 第三个参数为Tips，如果需要提示，则使用  
- 第四个参数为code,0或者负数，当失败的时候，可以使用负数  

#### 举例

请求成功返回：

	$this->echodata(1,array('List' => ''),'数据成功',0);

提示失败返回：

	$this->echodata(0,'','您查询的数据不存在',-1);
	
***echodata可以自动终止程序运行***
