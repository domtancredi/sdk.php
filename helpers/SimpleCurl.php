<?php

class SimpleCurl {
	
	private static $ch, $globalCurls;
	
	public function __construct() 
	{
		self::$ch = curl_init();

		self::$globalCurls = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_CAINFO => getcwd() . API_CERT
		);			
	}
	
	public static function addOptions($opts) 
	{
		// curl options are strange...you have to do the 
		// merge this way because array_merge changes keys
		// around and makes the keys strings...and the
		// keys are not strings they are constants...or something
		$mergedOptions = self::$globalCurls + $opts;
		self::setOptions($mergedOptions);
	}
	
	public function get($url) 
	{
		self::addOptions(array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0
		));		
		
		return $this->execute();
	}
	
	public function post($url, $headers, $postCount, $fields) 
	{
		self::addOptions(array(
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => $postCount,
			CURLOPT_POSTFIELDS => $fields
		));
		
		return $this->execute();	
	}

	public static function close() 
	{
		curl_close(self::$ch);
	}
	
	private function execute() 
	{
		try {
			$result = curl_exec(self::$ch);
			if (curl_getinfo(self::$ch, CURLINFO_HTTP_CODE) != 200) 
			{
				throw new Exception('<strong>Error trying to ExecuteWebRequest, returned: '.curl_getinfo(self::$ch, CURLINFO_HTTP_CODE));
				self::close();
			}	
		} 
		catch (Exception $e) 
		{
			if (API_ENV !==  'PRODUCTION')
			{
				echo "<pre>";
				var_dump($e);
				echo "<br><br>";
				var_dump ($result);
				echo "</pre>";
				die();					
			}

			header('Location:'. ERROR_REDIRECT);
		
		}
		
		return $result;
	}
	
	private static function setOptions($options) 
	{
		curl_setopt_array(self::$ch, $options);
	}
}
