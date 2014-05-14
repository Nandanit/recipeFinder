<?php

//represents a unit of ingredient, values possible defined in config.php
class Unit{

	//attributte
	private $measure;
	
	//class constructor
	public function __construct($measure){
		$this->setMeasure($measure);
	}
	
	/******* setter getter ***********/
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
	/******* end setter getter ***********/
	
	public function __toString(){
        return $this->measure;
    }
}
