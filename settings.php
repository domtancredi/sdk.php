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

