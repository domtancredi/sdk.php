<?php
function sortObjectsLowestDestructive ($a, $b) {
		return ($a->pricing->price < $b->pricing->price) ? -1 : 1;
}
function sortObjectsHighestDestructive ($a, $b) {
		return ($a->pricing->price > $b->pricing->price) ? -1 : 1;
}

function sortByLowestPricedOption($deal) {
	$sort_deals = $deal;
	usort($sort_deals, 'sortObjectsLowestDestructive');
	
	return $sort_deals;
}

function sortByHighestPricedOption($deal) {
	$sort_deals = $deal;
	usort($sort_deals, 'sortObjectsHighestDestructive');
	
	return $sort_deals;	
}

function countdownTimer($utc) {
 		$current = time();
}

function getDiscount($discountPrice, $originalPrice) {
	
	return ceil((($discountPrice*100) / $originalPrice));
}

function formatDate ($utc) {
	echo date("l n/j, h:iA T", $utc); 		
}

function getRawDate($uglyDate) {
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

function setGCCookie($cookieName, $cookieValue) {
		setcookie($cookieName, "", time()-3600);
		if ($cookieValue == 'favicon.ico')
			setCookie($cookieName, 'all', mktime().time()+60*60*24*30, "/");
		else
			setCookie($cookieName, $cookieValue, mktime().time()+60*60*24*30, "/");
}

function getGCCookie($cookieName) {
	if(!isset($_COOKIE[$cookieName])) return null;
	
	$cookieValue = $_COOKIE[$cookieName];
	if ($cookieValue == 'favicon.ico') {
		setCookie($cookieName, 'all', mktime().time()+60*60*24*30, "/");
		return null;
	}
	
	return $cookieValue;
}

function getRegions($segments) {
	foreach ($segments as $segment) {
		if ($segment->description == "#region#") {
			$regionSegments[] = $segment;
		}
	}
	
	return $regionSegments;
}

function getNeighborhoods($segments) {
	foreach ($segments as $segment) {
		if ($segment->description != "#region#") {
			$neighborhoodSegments[] = $segment;
		}
	}
	
	return $neighborhoodSegments;	
}

  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  function dateDiff($time1, $time2, $precision = 6) {
  	
  	if ($time1 < 0 || $time2 < 0 ) {
  		return "";
  	}
	
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }
 
    // Return string with times
    return implode(", ", $times);
  }

  function getPaymentType($cardNumber) {
		$visa = '/^4/';
		$mastercard = '/^5[1-5]/';
		$amex = '/^3[4|7]/';
		$diners = '/^3((0[0-5])|[6|8])/';
		$discover = '/^6011/';
		
		if (preg_match($visa, $cardNumber)) {
			return "Visa";
		} else if (preg_match($mastercard, $cardNumber)) {
			return "MasterCard";
		} else if (preg_match($amex, $cardNumber)) {
			return "Amex";
		} else if (preg_match($diners, $cardNumber)) {
			return "DinersClub";
		} else if (preg_match($discover, $cardNumber)) {
			return "Discover";
		} 
			
		return false;
  }
  
function currencyFormat($number) {
        $number = sprintf('%.2f', $number);
		$number = preg_replace('/\.0*$/', '', $number);

    return $number;
} 

function getYoutubeEmbedCode($url) {
	$youtubeRegex = '#youtu(?:\.be|be\.com)/(?:.*v(?:/|=)|(?:.*/)?)([a-zA-Z0-9-_]+)#';
	$begin = '<iframe width="638" height="375" src="';
	$connectChar = ((strpos($url,'?') !== false) ? '?' : '&');
	$wmode = 'wmode=opaque';
	$end = '" frameborder="0" allowfullscreen></iframe>';
	$embedHelp = 'http://www.youtube.com/embed/';

	if(preg_match($youtubeRegex, $url, $matches) && count($matches) > 1){
		return $begin.$embedHelp.$matches[1].'?'.$wmode.$end;
	}

	if(strpos($url, 'http') !== 0) {
		$url = 'http://'.$url;
	}

	if (strpos($url,'embed') !== false) {
		return $begin.$url.$connectChar.$wmode.$end;
	}

	$url_string = parse_url($url, PHP_URL_QUERY);
	parse_str($url_string, $args);
	
	if(isset($args['v'])) {
		return $begin.$embedHelp.$args['v'].'?'.$wmode.$end;
	} else {
		return $begin.$url.$connectChar.$wmode.$end;
	}	
}