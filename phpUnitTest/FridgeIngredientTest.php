<?php

include_once '../config.php';

//unit test class
class FridgeIngredientTest extends PHPUnit_Framework_TestCase{

	protected $fridgeIngredient;
	
    protected function setUp() {
        $this->fridgeIngredient = new FridgeIngredient(new Ingredient("butter", "250", "grams"), "26/12/2014");
    }
	
	protected function tearDown() {
        unset($this->fridgeIngredient);
    }
	
	public function testIsExpired() {
        $expected = false;
        $actual = $this->fridgeIngredient->isExpired();
        $this->assertEquals($expected, $actual);
    }
}
