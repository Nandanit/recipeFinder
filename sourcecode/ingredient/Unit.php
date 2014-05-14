<?php
class Unit{

	private $measure;
	
	public function __construct($measure){
		$this->setMeasure($measure);
	}
	
	public function setMeasure($measure){	
		if(in_array($measure, unserialize(UNIT_ENUM))){
			$this->measure = $measure;
		}else{
			throw new Exception("Error:". $measure . " is not listed in UNIT_ENUM in config file located in root directory");
		}
	}
	
	public function getMeasure(){
		return $this->measure;
	}
	
	public function __toString(){
        return $this->measure;
    }
}
