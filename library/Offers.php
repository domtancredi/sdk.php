<?php


class Offers extends PublisherBase {
   
   private $raw_response;
   
   public function __construct($response) 
   {
   	  parent::__construct($response->offers);
	  
   	  $this->raw_response = $response;		  
   }
   
   public function response()
   {
   		return $this->get_response($this->raw_response);
   }
   
}