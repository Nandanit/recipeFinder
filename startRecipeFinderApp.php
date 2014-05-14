<?php

include "config.php";

if($argc != 3){
	echo "\nUsage: php startRecipeFinderApp.php fridge.csv recipe.json.txt.\n";
}else{
	try{
		//initialize RecipeFinder and print recommended recipe
		$recipeFinder = new RecipeFinder($argv[1], $argv[2]);
		$commendedRecipe = $recipeFinder->recommendRecipe();
		echo $commendedRecipe;
	}catch(Exception $e){
		echo $e->getMessage(), "\n\n";
		echo "\nUsage: php startRecipeFinderApp.php fridge.csv recipe.json.txt\n\nor Double click: runRecipeFinder.bat\n";
	}
}

?>
