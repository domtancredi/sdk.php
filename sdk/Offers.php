<?php 

class Offers {
	
	private $offers;
	
	public function __construct($rawOffer) {
		$this->offers = $rawOffer;
	}
	
	public function getMetaData($meta) {
		return $this->offers->metaData->$meta;
	}
	
	public function getAPIInfo($apiData) {
		return $this->offers->$apiData;
	}
	
	public function getRawDate($uglyDate) {
		$uglyDate = substr($uglyDate, 6);
		
		$breaker = strpos($uglyDate, '+');
		
		if ($breaker == FALSE) {
			$breaker = strpos($uglyDate, '-');
			if ($breaker == FALSE) {
				$breaker = strpos($uglyDate, ')');
			}
		}
		
		$utc = substr($uglyDate, 0, $breaker);
		
		return $utc;
	}
} 