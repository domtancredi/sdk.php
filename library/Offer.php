<?php
/*
offer {
  ["classifications"]	=> list
  ["copy"]    			=> string
  ["customFields"]  => list
  ["demandStrategy"]    => DemandStrategy
  ["endDate"]            => datetime
  ["expirationDate"]       => datetime
  ["fineprint"]      => string
  ["hasEnded"]           => bool
  ["hasSoldOut"]          => bool
  ["headline"]       => string
  ["highlights"]     => string
  ["howToRedeemVoucher"]      => string
  ["images"]      => list
  ["locations"]      => list
  ["maxGiftQuantityPerBuyer"]      => int
  ["maxQuantityPerBuyer"]      => int
  ["merchant"]      => Merchant
  ["numberSold"]      => int
  ["offerId"]      => int
  ["offerKey"]      => string
  ["options"]      => list
  ["pricingStrategy"]      => PricingStrategy
  ["rank"]      => int
  ["redemptionInstructions"]      => string
  ["redemptionType"]      => RedemptionType
  ["requiresShippingAddress"]      => bool
  ["segments"]      => list
  ["sourcingPartners"]      => list
  ["startDate"]      => datetime
  ["subtitle"]      => string
  ["tags"]      => list
  ["url"]      => string
  ["video"]      => video
  ["voucherInstructions"]      => string
}
*/

class Offer extends Response {
   
   	public function __construct($offer_id)  
   	{
   		$api_call = PublisherApi::get_instance();
		
		$request = array('offerId' => $offer_id);
		
		parent::__construct($api_call->get_offer_by_id($offer_id), 'offer');		  
   	}

	public function get_offer()
	{
		return $this->get_everything();	
	}
}