<?php

class PublisherApi {

	private $options, $format;
		
	private static $instance = NULL;	

	public static function get_instance()
	{
		if (!self::$instance instanceof self)
		{
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	private  function __construct($format = "json") 
	{
		$this->options = array();
		
		if (strtolower($format)  == "xml")
		{
			$this->format = $format;
			$this->set_options('format', 'xml');
		}
	}

	public function get_segments()
	{
		$url = BASEURL . 'segments';
		
		return $this->response_decode($this->get_cache_request($url));
	}
	
	public function add_email_lead($request)
	{
		$url = BASEURL . 'emailLead';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function get_email_leads($request)
	{
		$url = BASEURL . 'emailleads';
		
		$this->set_options($request);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function validate_promo_code($request)
	{
		$url = BASEURL . 'offer/'.$request['OfferId'].'/promocode/'.$request['PromoCode'];
		
		$this->set_options($request);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_voucher($request)
	{
		$url = BASEURL . 'voucher';
		
		$this->set_options($request);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_voucher_preview($secret_key)
	{
		$url = BASEURL . 'voucher/preview';
		
		$this->set_options('secretKey', urlencode($secret_key));
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_offers($request)
	{
		$url = BASEURL . 'offers';
		
		$this->set_options($request);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_offer_by_id($offer_id)
	{
		$url = BASEURL . 'offer/' . $offer_id;
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_offers_for_segment_display($request)
	{
		$url = BASEURL . 'offersforsegmentdisplay';
		
		
		
		$this->set_options('segmentKey', $request);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function purchase($request)
	{
		$url = BASEURL . 'order';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function get_order_by_id()
	{
		$url = BASEURL . 'order/' . $order_id;
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_consumer_orders($user_key)
	{
		$url = BASEURL . 'consumer/' . urlencode($user_key) . '/orders/';
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_consumer($request)
	{
		$url = BASEURL . 'order/' . $request['UserKey'];
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function get_credit_cards($user_key)
	{
		$url = BASEURL . 'consumer/' . urlencode($user_key) . '/creditcards';
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function add_credit_cards($request)
	{
		$url = BASEURL . 'consumer/' . $request['UserKey'] . '/creditcard';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function edit_credit_cards($request)
	{
		$url = BASEURL . 'consumer/' . $request['UserKey'] . '/creditcard/' . $request['StoredCreditCardId'] ;
		
		return $this->response_decode($this->execute_request($url, $request));
	}	

	/**
	 * TODO: Something is a little strange with this call,
	 * need to make it work at a later date...
	 */
	public function delete_credit_cards($request) 
	{
		$url = BASEURL . 'consumer/' . $request['UserKey'] . '/creditcard/' . $request['StoredCreditCardId'] ;
		
		//return $this->response_decode($this->execute_request($url, $request, DELETE));		
	}
	
	public function refer_friends($request)
	{
		$url = BASEURL . 'referFriends/';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function share_offer($request)
	{
		$url = BASEURL . 'offers/' . $request['OfferId'] . '/share';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function create_ticket($request)
	{
		$url = BASEURL . 'createticket';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function generate_barcode($code)
	{
		$url = BASEURL . 'generatebarcode';
		
		$this->set_options('code', urlencode($code));
		
		return $this->response_decode($this->execute_request($url));
	}
		
	public function profilestore_create_profile($request)
	{
		$url = BASEURL . 'profilestore/create' ;
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_update_profile($request)
	{
		$url = BASEURL . 'profilestore/update';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_login($request)
	{
		$url = BASEURL . 'profilestore/login';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_change_password($request)
	{
		$url = BASEURL . 'profilestore/changepassword';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_reset_password($request)
	{
		$url = BASEURL . 'profilestore/resetpassword';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_forgot_password($request)
	{
		$url = BASEURL . 'profilestore/forgotpassword';
		
		return $this->response_decode($this->execute_request($url, $request));
	}
	
	public function profilestore_get_profile($request)
	{
		$url = BASEURL . 'profilestore';
		
		$this->set_options($request);
		
		return $this->response_decode($this->execute_request($url));
	}

	public function get_static_contentV2($request)
	{
		$url = BASEURL . 'staticcontent/' . http_build_query($request, '&amp;');
		
		$url = str_replace('/v3/', '/v2/', $url);
		
		return $this->response_decode($this->execute_request($url));
	}
	
	public function set_options($key, $value = NULL) 
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->options[$k] = $v;
			}
		}
		else 
		{
			$this->options[$key] = $value;	
		}
	}
	
	public function get_options($key) 
	{
		if (isset($this->options[$key])) 
		{
			unset($this->options[$key]);
		}	
	}
	
	public function reset_options() 
	{
		$this->options = array();
	}
	
	/**
	 * Just to make sure someone doesn't try and clone
	 * the singleton...
	 */
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }	
		
	private function response_decode($response) 
	{
		if ($this->format == 'xml')
		{
			return new SimpleXMLElement($response);
		}
			
		return json_decode($response);	
	}
	
	private function get_cache_request($url)
	{
		$request = new WebRequest($url);
		$request->setup_params($this->options, array());
		
		$this->reset_options();
		
		return $request->execute_cached_request();
	}
	
	private function execute_request($url, $post_data = array())
	{
		$request = new WebRequest($url);
		$request->setup_params($this->options, $post_data);
		
		$this->reset_options();
		
		return $request->execute_request();
	}

}