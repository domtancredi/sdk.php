<?php

/**
 * A super simple file cacheing system. You should probably use this  as
 * a fallback to some other, more robust caching system, like PHP's APC
 * see http://php.net/manual/en/book.apc.php for better caching methods
 */
class GCCache {
	
	private $timeout, $cacheDir;
	
	public function __construct($timeout, $cacheDir=null) {
		$this->timeout = (int)$timeout;
		$this->cacheDir = ($cacheDir != null) ? $cacheDir : './';
		
		if (!is_dir($this->cacheDir))
		{
			error_log("Your specified cacheDir is not a directory: ".$this->cacheDir, 0);
		}
		if (!is_writable($this->cacheDir))
		{
			error_log("Your specified cacheDir is either not writable: ".$this->cacheDir, 0);
		}
	}
	
	public function getCache($key) {

		$file = $this->cacheDir.'/'.sha1($key).'.json';

		if(!file_exists($file) || ($_SERVER['REQUEST_TIME'] - filemtime($file)) > $this->timeout) {
			return FALSE;
		}
		
		$handle = @fopen($file, 'rb');
		
		$data = @fread($handle, filesize($file));		
		fclose ($handle);
		
		return  $data; 
	}
	
	public function setCache($data, $key) {
		$file = $this->cacheDir .'/'.sha1($key).'.json';
		
		$handle = @fopen($file, 'wb');
		if ($handle !== FALSE) {
			@fwrite($handle, $data);		
			fclose ($handle);				
		} 		
		
		return $data;
	}
	
}