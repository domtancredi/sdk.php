<?php

$api_version 	= '3';

$api_cert 		= 'certs/cacert.pem';

$cachepath 		= 'cache'; 					// make sure this directory is writeable, otherwise, it won't write

$libpath 		= 'library';

$helperpath 	= 'helpers';

$error_redirect = 'errors/api_error.php'; 

$pub_api_config = array(
	'env_settings' => array(
		'LOCAL' => array(
			'env' 			=> 'gcapi.dev',
			'url' 			=> 'apitest.groupcommerce.com/api/',
			'key' 			=> '2ef75cb3-6579-49d3-a804-c0a0d1b3d5d0',
			'secret' 		=> 'fb79b235-5d38-4a76-96f2-bc1057ad8940',
			'cache_time' 	=> 60
		),
		'DEVELOPMENT' => array(
			'env' 			=> 'gctest.pagodabox.com',
			'url' 			=> 'apitest.groupcommerce.com/api/',
			'key' 			=> '2ef75cb3-6579-49d3-a804-c0a0d1b3d5d0',
			'secret' 		=> 'fb79b235-5d38-4a76-96f2-bc1057ad8940',
			'cache_time' 	=> 60	
		),
		'STAGING' => array(
			'env' 			=> '',
			'url' 			=> '',
			'key' 			=> '',
			'secret' 		=> '',
			'cache_time' 	=> ''			
		),
		'PRODUCTION' => array(
			'env' 			=> '',
			'url' 			=> '',
			'key' 			=> '',
			'secret' 		=> '',
			'cache_time' 	=> ''			
		)
	)
);

// ****************************************************************************
// ****************************************************************************
// Don't mess with anything below here, unless you know what you're doing...
// and even then...you probably shouldn't

foreach ($pub_api_config['env_settings'] as $settings)
{
   if ($settings['env'] == $_SERVER['HTTP_HOST'])
   {
      define('API_ENV', $settings['env']);
	  define('API_URL', $settings['url']);
	  define("API_VERSION", 'v'.$api_version);
	  define("API_KEY", $settings['key']);
	  define("API_SECRET", $settings['secret']);
	  define("API_CACHE_TIME",  $settings['cache_time']);
	  define("API_CERT", $api_cert);
	  define("CACHEPATH", $cachepath);
	  define("LIBPATH", $libpath);
	  define("HELPERPATH", $helperpath);
	  define("ERROR_REDIRECT", $error_redirect);
	  define("BASEURL", 'https://'. API_URL.API_VERSION.'/publisher/');
      define ('FLASH_COOKIE', 'flash_message');	 
	  break; 
   }
}

if (!defined('API_ENV')) 
{
   echo 'Error in Bootstrap: looks like '. $_SERVER['HTTP_HOST'] .' is not a defined environment.';
   die();
}

function __autoload($class_name)
{
	
	if (file_exists(LIBPATH .'/'. $class_name .'.php'))
	{
		require_once LIBPATH .'/'. $class_name .'.php';
	}
	else if (file_exists(HELPERPATH .'/'. $class_name .'.php'))
	{
		require_once HELPERPATH .'/'. $class_name .'.php';	
	}
	else if (file_exists($class_name . '.php'))
	{
		require_once $class_name .'.php';
	}
	else {
		echo "Can't load $class_name";
		var_dump ($e);	
		die();
	}
		
}