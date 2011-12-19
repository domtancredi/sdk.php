<?php

class Response {
	
	private $response, $response_data;

	protected $api_call;
	
	public $version, $last_published, $success, $errors, $meta;
	
	public function __construct($response, $name) 
	{
		$this->response = $response;
		$this->response_data = $response->$name;
				
		$this->version = (float) $response->version;
		$this->last_published = $response->lastPublished;
		$this->success = $response->success;
		
		$this->errors = new Errors($response->errors);	
	}
	
	public static function get_utc_date($jsonDate)
	{
		preg_match('/[0-9]+/i', $jsonDate, $utc);
		   
		return $utc[0];
	}
	
	public static function format_date($utc, $format="l n/j, h:iA T")
	{
		return date($format, $utc / 1000);
	}
	
	protected function get_everything()
	{
		return $this->response_data;
	}
	
	public function get_meta_item($key)
	{
		return isset($this->response->metaData->$key) ? $this->response->metaData->$key : NULL;
	}
				
	protected function get_item($key, $number)
	{
		return isset($this->pub_object[$number]->$item) ? $this->pub_object[$number]->$item : NULL;
	}
		
	protected function get_all_where($key, $value)
	{
		$x = array();
		
		foreach ($this->response_data as $data)
		{
			if (isset($data->$key) && $data->$key == $value)
			{
				$x[] = $data;
			}
		}
		
		return (count($x) > 0) ? $x : NULL;
	}
	
	protected function get_all($key)
	{
		$x = array();
		foreach ($this->pub_object as $data)
		{
			if (isset($data->$key))
			{
				$x[] = $data->$key;   
			}
		}		
		return (count($x) > 0) ? $x : NULL;		
	}	
}
