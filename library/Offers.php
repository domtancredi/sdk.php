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

class Offers extends Response {
   
   	public function __construct()  
   	{
   		$api_call = PublisherApi::get_instance();
		
		$request = array('pagenumber' => '1',
						 'pagesize' => '1',
						 'Timeframe' => '',
						 'startDate' => '',
						 'endDate' => '',
						 'OrderBy' => '',
						 'segmentKeys' => '',
						 'ClassificationKeys' => '',
						 'Tags' => '');
	
		
		parent::__construct($api_call->get_offers($request), 'offers');		  
   	}

	public function get_all_offers()
	{
		return $this->get_everything();	
	}
}