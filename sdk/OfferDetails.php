<?php 

require_once "Offers.php";

class OfferDetails extends Offers {
	
	private $details,
			$data;

	public $copy,
	       $demandStrategy,
	       $endDate,
	       $fineprint,
	       $highlights,
	       $maxQuantityPerBuyer,
	       $offerId,
	       $offerKey,
	       $pricingStrategy,
	       $redemptionInstructions,
	       $subtitle,
	       $headline,
	       $url, 
	       $video,
	       $locations,
	       $hasEnded,
	       $maxGiftQuantityPerBuyer,
	       $hasSoldOut;
	
	public function __construct($rawOffer) {
		parent::__construct($rawOffer);
		
		$this->details = $rawOffer;
		$this->data = $this->details->data;
		
		$this->copy						= $this->data->copy;
		$this->demandStrategy 			= $this->data->demandStrategy;
		$this->endDate 					= $this->getRawDate($this->data->endDate) / 1000;
		$this->fineprint	 			= $this->data->fineprint;
		$this->highlights 				= $this->data->highlights;
		$this->maxQuantityPerBuyer 		= $this->data->maxQuantityPerBuyer;
		$this->offerId 					= $this->data->offerId;
		$this->offerKey 				= $this->data->offerKey; 
		$this->pricingStrategy 			= $this->data->pricingStrategy;
		$this->redemptionInstructions 	= $this->data->redemptionInstructions;
		$this->headline 				= $this->data->headline;
		$this->url 						= $this->data->url;
		$this->video 					= $this->data->video;
		$this->subtitle					= $this->data->subtitle;
		$this->hasSoldOut				= $this->data->hasSoldOut;
		$this->hasEnded					= $this->data->hasEnded;
		$this->maxGiftQuantityPerBuyer	= $this->data->maxGiftQuantityPerBuyer;
		$this->locations				= $this->data->locations;
		$this->requiresShippingAddress	= $this->data->requiresShippingAddress;
		
	}
		
	public function getMerchantInfo() {
		return $this->data->merchant;
	}

	public function getMerchantAddress() {
		return $this->data->merchant->address;
	}
	
	public function getOfferImages() {
		return $this->data->images;
	}	
	
	public function getDealOptions() {
		return $this->data->options;
	}
	
	public function getSegments() {
		return $this->data->segments;
	}
	
	public function getTags() {
		return $this->data->tags;
	}
	
	public function convertDate($dateObject) {
		//THIS IS NOT CORRECT...DOES NOT ACCOUNT
		//FOR DST OR TIMEZONES YET...
		//DON'T USE THIS FOR ANYTHING
		$dateObject = substr($dateObject, 6);
		
		$breaker = strpos($dateObject, '-');
		
		(int)$utc = substr($dateObject, 0, $breaker);
		(string)$utc = $utc / 1000;
		
		return (object) array(
			"utc" => $utc,
			"friendly" => date('l m/d, gA T', $utc)
		);
	}
	
	public function getOptionById($optionId) {
		foreach ($this->data->options as $option) {
			if ($option->offerOptionId == $optionId) {
				return $option;
			}
		}
		
		die ('Error: Could not find option with ID'. $optionId);
	}
	
	public function getCustomFields($key) {
		$len = count($this->data->customFields);
		for ($i=0; $i < $len; $i++) {
			if ($this->data->customFields[$i]->Key == $key) {
				return $this->data->customFields[$i]->Value;
			}
		}
		
		die('Could not find' . $key . 'in getCustomFields');
	}
	
	
} 