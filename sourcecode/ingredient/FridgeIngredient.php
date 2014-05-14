<?php
class FridgeIngredient{

	private $ingredient;
	private $useByDate;
	private $expired = false;

	
	public function __construct($ingredient, $useByDate) {
		$this->ingredient = $ingredient;
		//echo "************{$useByDate}***********";
		$this->useByDate = DateTime::createFromFormat(EXPIRY_DATE_FORMAT, $useByDate);
		if(new DateTime() > $this->useByDate){
			$this->expired = true;
		}
		else{
			$this->expired = false;
		}
		//echo "\nthis->expired {$this->ingredient}= {$this->expired}\n";
    }
	
	public function getIngredient(){
		return $this->ingredient;
	}
	
	public function isExpired(){
		return $this->expired;
	}
	
	public function getUseByDate(){	
		return $this->useByDate;
	}
	
	public function __toString(){
        return $ingredient . "," . $this->useByDate->format(EXPIRY_DATE_FORMAT) . "," . $this->expired;
    }

}
