<?php
/*
segments {
  ["active"]         => boolean
  ["description"]    => string
  ["externalRefId"]  => int
  ["facebookUrl"]    => string
  ["key"]            => string
  ["latitude"]       => float
  ["longitude"]      => float
  ["name"]           => string
  ["notes"]          => string
  ["timezone"]       => string
  ["twitterUrl"]     => string
  ["viewOrder"]      => int
}
*/

class Segments extends Response {
   
   	public function __construct() 
   	{
   		$api_call = PublisherApi::get_instance();
		
   		parent::__construct($api_call->get_segments(), 'segments');		  
   	}
			  
	public function get_all_segments()
	{
		return $this->get_everything();	
	}
	
	public function get_active_segments() 
   	{
		return $this->get_all_where('active', TRUE);
   	}
   
   	public function get_inactive_segments() 
   	{
		return $this->get_by('active', FALSE);      
   	}
   	
   	public function get_segments_where($key, $value)
   	{
    	return $this->get_by($key, $value);
   	}
   
   	public function get_all_values($key)
   	{
    	return $this->get_items($key);
   	}
}