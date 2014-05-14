<?php

//FridgeIngredient class to represent ingredient in fridge 
class FridgeIngredient{

	//attributtes
	private $ingredient;
	private $useByDate;
	private $expired = false;

	//class constructor
	public function __construct($ingredient, $useByDate) {
		$this->ingredient = $ingredient;
		$this->useByDate = DateTime::createFromFormat(EXPIRY_DATE_FORMAT, $useByDate);
		if(new DateTime() > $this->useByDate){
			$this->expired = true;
		}
		else{
			$this->expired = false;
		}
    }
	
	/******* setters getters ***********/
	public function getIngredient(){
		return $this->ingredient;
	}
	
	public function setIngredient($ingredient){
		$this->ingredient = $ingredient;
	}
	
	public function isExpired(){
		return $this->expired;
	}
	
	public function setExpired($expired){
		$this->expired = $expired;
	}
	
	public function getUseByDate(){	
		return $this->useByDate;
	}
	
	public function setUseByDate($useByDate){	
		$this->useByDate = DateTime::createFromFormat(EXPIRY_DATE_FORMAT, $useByDate);
	}
	/******* end setters getters ***********/
	
	public function __toString(){
        return $ingredient . "," . $this->useByDate->format(EXPIRY_DATE_FORMAT) . "," . $this->expired;
    }

}
