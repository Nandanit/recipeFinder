<?php
class Ingredient{

	private $item;
	private $amount;
	private $unit;
	
	public function __construct($item, $amount, $unit) {
        $this->item = $item;
		$this->amount = $amount;
		try {
			$this->unit = new Unit($unit);
		} catch (Exception $e) {
			throw new Exception("Error:". $measure . " is not listed in UNIT_ENUM in config file located in root directory");	
		}
    }
	
	public function getItem(){
		return $this->item;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function __toString(){
        return $this->item . "," .$this->amount . "," . $this->unit;
    }
}




