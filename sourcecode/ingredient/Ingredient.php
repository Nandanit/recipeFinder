<?php

//class to represent ingredient in recipie and fridge
class Ingredient{

	//attributtes
	private $item;
	private $amount;
	private $unit;
	
	//class constructor
	public function __construct($item, $amount, $unit) {
        $this->item = $item;
		$this->amount = $amount;
		try {
			$this->unit = new Unit($unit);
		} catch (Exception $e) {
			//$measure defined in config.php
			throw new Exception("Error: ". $unit . " is not listed in UNIT_ENUM in config file located in root directory");	
		}
    }
	
	/******* setters getters ***********/
	public function getItem(){
		return $this->item;
	}
	
	public function setItem($item){
		$this->item = $item;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function setAmount($amount){
		$this->amount = $amount;
	}
	
	/******* end setters getters ***********/
	
	public function __toString(){
        return $this->item . "," .$this->amount . "," . $this->unit;
    }
}




