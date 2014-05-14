<?php

include "config.php";

if($argc != 3){
	echo "\nUsage: php startRecipeFinderApp.php fridge.csv recipe.json.\n";
}else{
	//initialize RecipeFinder and print recommended recipe
	$recipeFinder = new RecipeFinder($argv[1], $argv[2]);
	$commendedRecipe = $recipeFinder->recommendRecipe();
	echo $commendedRecipe;
}

?>
