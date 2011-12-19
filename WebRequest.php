<?php

class WebRequest {
	
	private $url, $params, $post_data, $cache;
	
	public function __construct($url) 
	{
		$this->url = $url;	
		$this->params = NULL;
		$this->post_data = array();
		
		$this->cache = new GCCache(API_CACHE_TIME, CACHEPATH);
	}
	
	public function execute_request()
	{
		$oauth = new OAuthSimple(API_KEY, API_SECRET);
		$curl = new SimpleCurl();
		$post_count = count($this->post_data);
				
		if (!is_null($this->params)) 
		{
			$oauth->setParameters($this->params);
		}
		
		$oauth->setPath($this->url);
		
		if ($post_count == 0) 
		{
			$oAuthResult = $oauth->sign();
			$result = $curl->get($oAuthResult['signed_url']);
		} 
		else 
		{
			$oauth->setAction('POST');
			$oAuthResult = $oauth->sign();

			$result = $curl->post($this->url, array("Authorization: ".$oAuthResult['header']), $post_count, self::encode_data($this->post_data));
		}
		
		$curl::close();
		
		return $result;		
	}
	
	public function execute_cached_request()
	{
		$x = $this->cache->getCache($this->url, $this->params);
		
		if ($x === FALSE) 
		{
			$data = $this->execute_request();
			$x = $this->cache->setCache($data, $this->url, $this->params);
		} 		
		
		return $x;
	}
	
	public function setup_params($options = NULL, $post_data = array())
	{
		$this->post_data = $post_data;
		
		if (count($options) > 0 && count($post_data) > 0)
		{
			$this->params = array_merge($options, $post_data);
		}
		else if (count($options) > 0)
		{
			$this->params = $options;
			
		}	
		else if (count($post_data) > 0)
		{
			$this->params = $post_data;
		}
		
		return NULL;		
	}
	
	public static function dbug($value, $kill = FALSE) 
	{
		echo "<pre>";
		var_dump($value);
		if ($kill)
		{
			die();
		}
		echo "</pre>";
	}
	
	public static function encode_data($unencoded)
	{
		$encoded = '';
		
		foreach ($unencoded as $key=>$value) 
		{
			$encoded .= self::escape_data($key).'='.self::escape_data($value).'&';
		}
		
		$encoded = rtrim($encoded, '&');
		
		return $encoded;		
	}
	
	public static function escape_data($string)
	{
      if ($string === 0) { return 0; }
	  if ($string == '0') { return '0'; }
      if (strlen($string) == 0) { return ''; }
      
      if (is_array($string)) 
      {
         throw new Exception('Hey, no arrays to escape_data');
	  }
	  
      return rawurlencode($string);
	}
}