<?php
require_once 'libraries/OAuthSimple.php';
require_once 'libraries/SimpleCurl.php';
require_once 'libraries/Cache.php';

class GCApi {

	private $api_url, $api_version, $api_key, $api_secret, $cache, $options, $cert, $api_cache_time, $error_redirect, $cert_location;
		
	public function __construct() 
	{
		$config = simplexml_load_file("web.config");
		foreach($config->appSettings->add as $configValue) 
		{
			$this->$configValue['key'] = $configValue['value'];
		}
		
		if (!defined('BASEURL'))
		{
			define ('BASEURL', 'https://'.$this->api_url.'/'.$this->api_version.'/publisher/');
		}
		$this->cache = new GCCache((int)$this->api_cache_time, $this->api_cache_dir);
		$this->cert = getcwd() . $this->cert_location;
	}
	
	public function GetPreviewVoucher($secretKey, $code) 
	{
		$url = BASEURL.'voucher/preview';
			
		$this->setOptions(array(
			'secretKey' => $secretKey
		));	
			
		//don't cache this, unique per deal...	
		return json_decode($this->ExecuteWebRequest($url));		
	}
	
	public function GetVoucher($secretKey, $code)
	{
		$url = BASEURL.'voucher';
			
		$this->setOptions(array(
			'secretKey' => $secretKey,
			'code' => $code
		));	
			
		//don't cache this, unique per purchase...	
		return json_decode($this->ExecuteWebRequest($url));
	}
	
	public function GenerateBarcode($code) 
	{
		$url = BASEURL.'barcode/'.$code;	
		
		//don't cache this, it's unique per voucher...
		return json_decode($this->ExecuteWebRequest($url));
	}
	
	public function ShareOffer($shareOffer) 
	{
		$url = BASEURL.'offers/'.$shareOffer['OfferId'].'/share';
		
		return json_decode($this->ExecuteWebRequest($url, $shareOffer));
	}
	
	public function GetOrderById($orderId) 
	{
		$url = BASEURL.'order/'.(string)$orderId;
		
		return json_decode($this->ExecuteCachedRequest($url)); 	
	}
	
	public function GetSegments() 
	{
		$url = BASEURL.'segments';
		return json_decode($this->ExecuteCachedRequest($url));
	}
	
	public function GetCurrentOffers($segment) 
	{
		$url = BASEURL. 'offers/current/'.$segment; 
		
		return json_decode($this->ExecuteCachedRequest($url)); 
	}
	
	public function GetOfferById($offerId) 
	{
		$url = BASEURL.'offer/'.$offerId;
		
		return json_decode($this->ExecuteCachedRequest($url)); 
	}

	public function Purchase($purchase) 
	{
		$url = BASEURL.'order/purchase';
		
		return json_decode($this->ExecuteWebRequest($url, $purchase));
	}
	
	public function GetConsumerOrders($userKey) 
	{
		$url = BASEURL.'consumer/'.self::escapeData($userKey).'/orders';
		
		return json_decode($this->ExecuteWebRequest($url)); 
	}
	
	public function InviteFriend($invite) 
	{
		$url = BASEURL.'invite/'.$invite['SegmentKey'];
		
		return json_decode($this->ExecuteWebRequest($url, $invite));
	}
	
	public function Contact($contact) 
	{
		$url = BASEURL.'contact';
		
		return json_decode($this->ExecuteWebRequest($url, $contact));
	}

	public function AddToWaitlist($request) 
	{
		$url = BASEURL . 'waitlist/'.$request['OfferOptionId'];
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function AddEmailLead($request) 
	{
		$url = BASEURL. 'emailLead';
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function ProfileStore_CreateProfile($request) 
	{
		$url = BASEURL . 'profilestore/create';
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function ProfileStore_UpdateProfile($request) 
	{
		$url = BASEURL . 'profilestore/update';
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function ProfileStore_Login($request) 
	{
		$url = BASEURL . 'profilestore/login';
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function ProfileStore_ResetPassword($request) 
	{
		$url = BASEURL . 'profilestore/resetpassword';
		
		return json_decode($this->ExecuteWebRequest($url, $request));
	}
	 
	public function ProfileStore_ChangePassword($request) 
	{
		$url = BASEURL . 'profilestore/changepassword';
		
		return json_decode($this->ExecuteWebRequest($url, $request));		
	}
	 
	public function ProfileStore_ForgotPassword($request) 
	{
		$url = BASEURL . 'profilestore/forgotpassword';
		
		return json_decode($this->ExecuteWebRequest($url, $request));		
	}
	 
	/*
	 * This works a little different than in .NET
	 * use $this->gc->setOptions() to set the UserKey.
	 * Check out profile getProfile() in profile.php for 
	 * and example of how to use this correctly.
	 */ 
	public function ProfileStore_GetProfile() 
	{
		$url = BASEURL . 'profilestore/';
		
		return json_decode($this->ExecuteWebRequest($url));		
	}

	public function setOptions($options) 
	{
		$this->options = $options;
	}
	
	public function deleteOption($optionKey) 
	{
		if (isset($this->options[$optionKey])) 
		{
			unset($this->options[$optionKey]);
		}	
	}
	
	public function resetOptions() 
	{
		$this->setOptions(NULL);
	}
	
	private function ExecuteWebRequest($url, $postData=array()) 
	{
		$oauth = new OAuthSimple($this->api_key, $this->api_secret);
		$curl = new SimpleCurl();
		$postCount = count($postData);
		
		$signParams = $this->setupParams($this->options, $postData);
		
		if (isset($signParams)) 
		{
			$oauth->setParameters($signParams);
		}
		
		$oauth->setPath($url);
		
		if ($postCount == 0) 
		{
			$oAuthResult = $oauth->sign();
			$result = $curl->get($oAuthResult['signed_url']);
		} 
		else 
		{
			$oauth->setAction('POST');
			$oAuthResult = $oauth->sign();

			$result = $curl->post($url, array("Authorization: ".$oAuthResult['header']), $postCount, $this->PostEncodeData($postData));
		}
		
		$curl->close();
		$this->resetOptions();
		
		return $result;
	}

	private function setupParams($options, $postData)
	{
		if (!is_null($this->options) && count($postData) > 0)
		{
			$signParams = array_merge($this->options, $postData);
		}
		else if (!is_null($this->options))
		{
			return $this->options;
		}	
		else if (count($postData) > 0)
		{
			return $postData;
		}
		
		return NULL;
	}
	
	private function ExecuteCachedRequest($url) 
	{
		$x = $this->cache->getCache($url, $this->options);
		
		if ($x === FALSE) 
		{
			$options = $this->options; // ExecuteWeb Request will reset options
			$data = $this->ExecuteWebRequest($url);
			$x = $this->cache->setCache($data, $url, $options);
		} 		
		
		return $x;
	}

	private function PostEncodeData($postDataElements) 
	{
		$encodedData = '';
		foreach ($postDataElements as $postDataKey=>$postDataValue) 
		{
			$encodedData .= self::escapeData($postDataKey).'='.self::escapeData($postDataValue).'&';
		}
		$encodeData = rtrim($encodedData, '&');
		
		return $encodeData;
	}
	
	private static function escapeData($string) 
	{
        if ($string === 0) { return 0; }
		if ($string == '0') { return '0'; }
        if (strlen($string) == 0) { return ''; }
        if (is_array($string)) {
            throw new Exception('Hey, no arrays to escapeData');
		}
        $string = rawurlencode($string);
		
       	$string = str_replace('+','%20',$string);
        $string = str_replace('!','%21',$string);
        $string = str_replace('*','%2A',$string);
        $string = str_replace('\'','%27',$string);
        $string = str_replace('(','%28',$string);
        $string = str_replace(')','%29',$string);		

        return $string;	
	}
}