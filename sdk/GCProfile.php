<?php

class GCProfile {
	
	public $profile, $profileData;
	
	public function __construct($profile) 
	{
		$this->profile = $profile->data;
		
		$this->set_profileData();
	}	
	
	public function get_item($for)
	{
		
		if (isset($this->profile->$for))
		{
			return $this->profile->$for;
		}
		elseif (isset($this->profileData[$for]))
		{
			return $this->profileData[$for];
		}
		elseif (isset($this->profileData['Profile_'.$for]))
		{
			return $this->profileData['Profile_'.$for];
		}
		else 
		{
			return NULL;
		}
	}
	
	public function prep_update($new_values)
	{
		$inputs = array();
		$x = get_object_vars($this->profile);
		
		foreach ($x as $k => $v)
		{
			if (is_array($v))
			{
				foreach ($v as $profData)
				{
					if (isset($new_values['ignore_dealType'])) 
					{
						$inputs[$profData->Key] = $profData->Value;
					}
					else 
					{
						if (preg_match('/Profile_dealType_*/', $profData->Key) && isset($new_values[$profData->Key]))
						{
							$inputs[$profData->Key] = $profData->Value;
						}
						else if (!preg_match('/Profile_dealType_*/', $profData->Key))
						{
							$inputs[$profData->Key] = $profData->Value;
						}						
					}

				}
			}
			else 
			{
				$inputs[$k] = $v;
			}
			
		}
		$y = array_merge($inputs, $new_values);
		unset($y['email']);
		unset($y['ignore_dealType']);
		
		return $y;
	}
	
	private function set_profileData()
	{
		foreach ($this->profile->profileData as $profileObjects)
		{
			$this->profileData[$profileObjects->Key] = $profileObjects->Value;
		}
	}
	
	public function dump()
	{
		echo "<pre>";	
		var_dump($this->profile);
		echo "</pre>";
		die();
	}
	
}
