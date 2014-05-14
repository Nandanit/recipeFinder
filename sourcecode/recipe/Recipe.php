<?php

//class to represent a Recipe
class Recipe{

	//attributtes
	private $name;
	private $ingredients;
	
	//class constructor
	public function __construct($name, $ingredients) {
        $this->name = $name;
		$this->ingredients = $ingredients;
    }
	
	/******* setters getters ***********/
	public function getingredients(){
		return $this->ingredients;
	}
	
	public function setingredients($ingredients){
		$this->ingredients = $ingredients;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	/******* end setters getters ***********/
	
	public function __toString(){
        return $this->name . "," .$this->ingredients;
    }
}

