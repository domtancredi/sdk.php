<?php 

require_once "Offers.php";

class OfferList extends Offers {
	
	private $offer,
			$offerData,
			$offerImages,
			$offerOptions;
	
	public function __construct($rawOffer) {
		parent::__construct($rawOffer);
	
		$this->offer = $rawOffer;
		$this->offerData = $this->offer->data;
	}
	
	public function getOffersFromAllSegments($segments) {
		
	}
	
	public function getAllOffers() {
		return $this->offerData;
	}
		
	public function getOffer($number) {
		return $this->offerData[$number];
	}
	public function getDealImage($deal, $image) {
		return $deal->images[$image];
	}
	
	public function getDealImages($deal) {
		return $deal->images;	
	}
	
	public function getOptions($deal) {
		return $deal->options;
	}
	
	public function getOption($deal, $option) {
		return $deal->options[$option];
	}
	
} 