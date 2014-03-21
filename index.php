<?php
/**
* @file index.php
* @synopsis  免费电影票 增加BASEDIRS常量
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2014-03-13 18:21:06
*/

 define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
 switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		@ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
		@ini_set('display_errors', 0);
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_* constants not yet defined; 1 is EXIT_ERROR, a generic error.
}

	$system_path = 'system';
	$application_folder = 'application';
	$view_folder = '';

	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.'/';
	}
	else
	{
		$system_path = rtrim($system_path, '/').'/';
	}
	if ( ! is_dir($system_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_* constants not yet defined; 3 is EXIT_CONFIG.
	}

	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('BASEPATH', str_replace('\\', '/', $system_path));
	define('FCPATH', str_replace(SELF, '', __FILE__));
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}

		define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
	}
	else
	{
		if ( ! is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
		{
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_* constants not yet defined; 3 is EXIT_CONFIG.
		}

		define('APPPATH', BASEPATH.$application_folder.DIRECTORY_SEPARATOR);
	}

	if ( ! is_dir($view_folder))
	{
		if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
		{
			$view_folder = APPPATH.$view_folder;
		}
		elseif ( ! is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
		{
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_* constants not yet defined; 3 is EXIT_CONFIG.
		}
		else
		{
			$view_folder = APPPATH.'views';
		}
	}

	if (($_temp = realpath($view_folder)) !== FALSE)
	{
		$view_folder = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		$view_folder = rtrim($view_folder, '/\\').DIRECTORY_SEPARATOR;
	}

	define('VIEWPATH', $view_folder);
	define('BASEDIRS',dirname(__FILE__). '/');
	require_once BASEPATH.'core/CodeIgniter.php';
