<?php
require_once "GCObject.php";

class Segments extends GCObject {
	
	private $segments;
	
	public function __construct($segments) {
		parent::__construct();
		$this->segments = $segments;
		
		$this->data = $this->segments->data;
		$this->metaData = $this->segments->metaData;
		$this->success = $this->segments->success;
		$this->version  = $this->segments->version;
		$this->lastPublished = $this->getUTCDate($this->segments->lastPublished);
	}
	
	public function getAllSegments() {
		return $this->data;
	}
	
	public function getSegmentByName($name) {
		return $this->getSegment('name', $name);
	}
	
	public function getSegmentByKey($key) {
		return $this->getSegment('key', $key);
	}
	
	public function getActiveSegments() {
		$obj = array();
		foreach ($this->data as $segment) {
			if ($segment->active == '1') {
				$obj[] = $segment;
			}
		}
		
		return $obj;
	}
	
	public function getInactiveSegments() {
		$obj = array();
		foreach ($this->data as $segment) {
			if ($segment->active != '1') {
				$obj[] = $segment;
			}
		}
		
		return $obj;		
	}
	
	private function getSegment($how, $what) {
		foreach ($this->data as $segment) {
			if ($segment->$how == $what) {
				return $segment;
			}
		}
		
		return FALSE;
	}
		
}
