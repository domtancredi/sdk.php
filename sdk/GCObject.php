<?php

require_once APPPATH. "third_party/gcapi/GCApi.php";

class GCObject  {
	
	public $meta;
	public $data;
	public $version;
	public $success;
	public $error;
	public $message;
	public $lastPublished;
	
	protected $gc;
	
	public function __construct() {
		$this->gc = new GCApi();
	}
	
	public function getUTCDate($jsonDate) {
		$jsonDate = substr($jsonDate, 6);
		
		$breaker = strpos($jsonDate, '+');
		
		if ($breaker == FALSE) {
			$breaker = strpos($jsonDate, '-');
			if ($breaker == FALSE) {
				$breaker = strpos($jsonDate, ')');
			}
		}
		
		$utc = substr($jsonDate, 0, $breaker);
		
		return $utc;		
	}
	
	public function formatDate($jsonDate, $format) {
		$utc = $this->getUTCDate($jsonDate);
		
		//date("l n/j, h:iA T", $utc); 
		return date($format, $utc); 
	}
	
}
