<?php

include_once '../config.php';

//unit test class
class RecipeTest extends PHPUnit_Framework_TestCase{

	protected $recipe;

	protected function setUp() {
		$ingredients = array(new Ingredient("bread", "2", "slices"), new Ingredient("cheese", "2", "slices"));
        $this->recipe = new Recipe("grilled cheese on toast", $ingredients);
    }
	
	protected function tearDown() {
        unset($this->recipe);
    }
	
	public function testGetingredients(){
		$expected = array(new Ingredient("bread", "2", "slices"), new Ingredient("cheese", "2", "slices"));
        $actual = $this->recipe->getingredients();
		$this->assertEquals($expected, $actual);
	}
	
	public function testGetName(){
		$expected = "grilled cheese on toast";
		$actual = $this->recipe->getName();
		$this->assertEquals($expected, $actual);
	}
	
}