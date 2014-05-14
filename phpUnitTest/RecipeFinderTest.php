<?php

include_once '../config.php';

//unit test class
class RecipeFinderTest extends PHPUnit_Framework_TestCase{
	
	protected $recipeFinder;
	
    protected function setUp() {
        $this->recipeFinder = new RecipeFinder("fridgeTest.csv", "recipie.jsonTest.txt");
    }
	
	protected function tearDown() {
        unset($this->recipeFinder);
    }
	
	public function testRecommendRecipe() {
        $expected = "grilled cheese on toast";
        $actual = $this->recipeFinder->recommendRecipe();
        $this->assertEquals($expected, $actual);
    }
}
