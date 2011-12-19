<?php

class SimpleCurl {
	
	private $globalCurls, $redirect;
	
	private static $ch;
	
	public function __construct() 
	{
		self::$ch = curl_init();
		$this->redirect = '/application/errors/';
		$this->globalCurls = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_CAINFO => getcwd() . '\certs\cacert.pem'
		);			
	}
	
	public function addOptions($opts) 
	{
		// curl options are strange...you have to do the 
		// merge this way because array_merge changes keys
		// around and makes the keys strings...and the
		// keys are not strings they are constants...or something
		$mergedOptions = $this->globalCurls + $opts;
		$this->setOptions($mergedOptions);
	}
	
	public function get($url) 
	{
		$this->addOptions(array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0
		));		
		
		return $this->execute();
	}
	
	public function post($url, $headers, $postCount, $fields) 
	{
		$this->addOptions(array(
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => $postCount,
			CURLOPT_POSTFIELDS => $fields
		));
		
		return $this->execute();	
	}

	public function close() 
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
				$this->close();
			}	
		} 
		catch (Exception $e) 
		{
			header('Location:'.$this->redirect);		
		}
		
		return $result;
	}
	
	private function setOptions($options) 
	{
		curl_setopt_array(self::$ch, $options);
	}
}
