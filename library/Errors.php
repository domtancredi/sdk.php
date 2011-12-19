<?php
/*
errors {
	array(
		[code]				=> String
		[defaultMessage]	=> String
		[key]				=> String
	)	
}
*/

class Errors {
	
	private $errors;
   
	public function __construct($errors)
	{
		$this->errors = $errors;
	}
	
	public function get_keys()
	{
		return $this->_get('key');
	} 
	
	public function get_messages()
	{
		return $this->_get('defaultMessage');
	}
	
	public function get_codes()
	{
		return $this->_get('code');
	}
	
	public function get_error_count()
	{
		return count($this->errors);
	}	
	
	private function _get($key)
	{
		$x = array();
		
		foreach ($this->errors as $error)
		{
			if (isset($error->$key))
			{
				$x[] = $error->$key;
			}
		}
		
		return (count($x) > 0) ? $x : NULL;
	}
}