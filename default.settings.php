<?php

$api_version 	= '3';

$api_cert	= 'certs/cacert.pem';

$cachepath 	= 'cache'; 					// make sure this directory is writeable, otherwise, it won't write

$libpath 	= 'library';

$helperpath 	= 'helpers';

$error_redirect = 'errors/api_error.php'; 

$pub_api_config = array(
	'env_settings' => array(
		'LOCAL' => array(
			'env' 			=> '', // Environment Host, 'www.example.local'
			'url' 			=> '', // GC Api End Point Url 'apitest.groupcommerce.com/api/'
			'key' 			=> '', // GC Api Key
			'secret' 		=> '', // GC Api Secret
			'cache_time' 		=> 0, // Number of seconds before cache is invalidated
		),
		'DEVELOPMENT' => array(
			'env' 			=> '',
			'url' 			=> '',
			'key' 			=> '',
			'secret' 		=> '',
			'cache_time' 	=> ''		
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
