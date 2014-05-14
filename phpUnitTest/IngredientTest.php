<?php

include_once '../config.php';

//unit test class
class IngredientTest extends PHPUnit_Framework_TestCase{

	protected $ingredient;
	
    protected function setUp() {
        $this->ingredient = new Ingredient("butter", "250", "grams");
    }
	
	protected function tearDown() {
        unset($this->ingredient);
    }
	
	public function testGetItem() {
        $expected = "butter";
        $actual = $this->ingredient->getItem();
        $this->assertEquals($expected, $actual);
    }
	
	public function testGetAmount(){
		$expected = 250;
		$actual = $this->ingredient->getAmount();
		$this->assertEquals($expected, $actual);
	}
	
}

