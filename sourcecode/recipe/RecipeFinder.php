<?php

//make this class final
class RecipeFinder{

	private $fridgeCsvFile;
	private $recipeJsonFile;
	private $fridgeIngredients = array();
	private $recipes = array();
	
	public function __construct($fridgeCsvFile, $recipeJsonFile){
		$this->fridgeCsvFile = $fridgeCsvFile;
		$this->recipeJsonFile = $recipeJsonFile;
		$this->readFridgeCsvFile($this->fridgeCsvFile);
		$this->readRecipeJsonFile($this->recipeJsonFile);
	}
	
	public function getFridgeIngredients(){
		return $this->fridgeIngredients;
	}
	
	public function getRecipes(){
		return $this->recipes;
	}
	
	public function recommendRecipe(){
		$recommendedRecipe = null;
		$recipeExpiry = null;
		for($rcpCounter=0;$rcpCounter<count($this->recipes);$rcpCounter++){
			$currentRecipe = $this->recipes[$rcpCounter];
			$ingredientsRequired = $currentRecipe->getingredients();
			
			list($ingredientAvailableToMakeRecipe, $recipeExpiryDate) =  $this->areIngredientsInFridge($ingredientsRequired);
			
			//////////////remove///////////////////////
			if($ingredientAvailableToMakeRecipe){
				//echo "\nIngredient available for: " . $currentRecipe->getName(). ", recipe expiry = " . $recipeExpiryDate->format(EXPIRY_DATE_FORMAT) . "\n\n\n\n\n"; 
			}else{
				//echo "\nIngredient not available for: " . $currentRecipe->getName(). "\n\n\n\n\n"; 
			}
			//////////////end remove///////////////////////
			
			
			if($ingredientAvailableToMakeRecipe){
				if(is_null($recipeExpiry)){
					$recommendedRecipe = $currentRecipe->getName();
					$recipeExpiry = $recipeExpiryDate;
				}else if($recipeExpiryDate < $recipeExpiry){ ///consider <=
					$recommendedRecipe = $currentRecipe->getName();
					$recipeExpiry = $recipeExpiryDate;
				}
			}
			//print_r($b);
			//echo "\n\nFirst recipe end \n";;
			//break;
		}
		//echo "\n\n\n recommendedRecipe={$recommendedRecipe}\n";
		//echo "\n\n\n recommendedExpiry={$recipeExpiry->format(EXPIRY_DATE_FORMAT)}\n";
		
		if(is_null($recommendedRecipe)){
			return "Order Takeout";
		}
		
		return $recommendedRecipe;
	}
	/*
	private function getRecipesPossibleFromFrdge($recipe){
		
		//echo "\nRecipe Name: " . $recipe->getName()."\n";
		$ingredientsRequired = $recipe->getingredients(); 
		$ingredientAvailableForRecipe = array();
		
		//if($this->areIngredientsInFridge($ingredientsRequired)){
		//	echo "\nIngredient available for: " . $recipe->getName(). "\n\n\n\n"; 
		//}else{
			//echo "\nIngredient not available for: " . $recipe->getName(). "\n\n\n\n\n"; 
		//}
		
		list($ingredientAvailableToMakeRecipe, $recipeExpiryDate) =  $this->areIngredientsInFridge($ingredientsRequired);
		
		
		if($ingredientAvailableToMakeRecipe){
			echo "\nIngredient available for: " . $recipe->getName(). ", recipe expiry = " . $recipeExpiryDate->format(EXPIRY_DATE_FORMAT) . "\n\n\n\n\n"; 
		}else{
			echo "\nIngredient not available for: " . $recipe->getName(). "\n\n\n\n\n"; 
		}
		
		return $ingredientAvailableForRecipe;
		
	}
	*/
	
	private function areIngredientsInFridge($ingredientsRequiredForRecipe){
		
		$recipeExpireDate = null;
		for($i=0;$i<count($ingredientsRequiredForRecipe);$i++){
		
			$ingredient = $ingredientsRequiredForRecipe[$i]; //required for recipe
			$ingredientRequiredForRecipe = $ingredient->getItem();
			$ingredientAmtRequiredForRecipe = $ingredient->getAmount();
			
			//echo "\ningredientRequiredForRecipe = {$ingredientRequiredForRecipe}\n";
			//echo "\ningredientAmtRequiredForRecipe = {$ingredientAmtRequiredForRecipe}\n";
			//$fridgeIngredients
			$ingrdntInFrdge = false;
			for($m=0;$m<count($this->fridgeIngredients);$m++){
				$currentFrdgIngrdnt = $this->fridgeIngredients[$m];
				$currentFrdgIngrdntName = $currentFrdgIngrdnt->getIngredient()->getItem();
				$currentFrdgIngrdntAmt = $currentFrdgIngrdnt->getIngredient()->getAmount();
				$currentFrdgIngrdntUseByDate = $currentFrdgIngrdnt->getUseByDate();
				
				if($ingredientRequiredForRecipe != $currentFrdgIngrdntName){
					continue;
				}else{
					//echo "\ncurrentFrdgIngrdntName = {$currentFrdgIngrdntName}\n";
					//echo "\ningredientAmtRequiredForRecipe = {$ingredientAmtRequiredForRecipe}\n";
					//echo "\ncurrentFrdgIngrdntAmt = {$currentFrdgIngrdntAmt}\n";
					//$tmp = $currentFrdgIngrdnt->isExpired();
					//echo "\ncurrentFrdgIngrdnt->isExpired() = {$tmp}\n";
					
					if($ingredientAmtRequiredForRecipe <= $currentFrdgIngrdntAmt  && !$currentFrdgIngrdnt->isExpired()){
						//echo "here";
						$ingrdntInFrdge = true;
						if(is_null($recipeExpireDate)){
							$recipeExpireDate = $currentFrdgIngrdnt->getUseByDate();
						}else if($currentFrdgIngrdnt->getUseByDate() < $recipeExpireDate){
							$recipeExpireDate = $currentFrdgIngrdnt->getUseByDate();
						}
					}else{
						return array(false, null);
					}
				}
				//echo "\currentFrdgIngrdntName = {$currentFrdgIngrdntName}\n";
				//echo "\ncurrentFrdgIngrdntAmt = {$currentFrdgIngrdntAmt}\n";
				//var_dump($currentFrdgIngrdntUseByDate);
				//echo "\ncurrentFrdgIngrdntUseByDate = {$currentFrdgIngrdntUseByDate->format('d/m/Y')}\n";//var_dump($currentFrdgIngrdntUseByDate)."\n";
				///echo "\ningredientRequiredForRecipe = {$ingredientRequiredForRecipe}\n";
				
				//if($currentFrdgIngrdnt->isExpired()){
					//echo "\nexpired\n";
				//}else{
					//echo "\nnot expired\n";
				//}
				
			}
			
			if($ingrdntInFrdge){
				continue;
			}else{
				return array(false, null);
			}
		}
		return array(true, $recipeExpireDate);
	}
	
	
	private function readFridgeCsvFile($fridgeCvFile){
		$frdgCsvHndlr = fopen($fridgeCvFile,"r");
		while(!feof($frdgCsvHndlr)){
			list($item, $amount, $unit, $useByDate) = fgetcsv($frdgCsvHndlr);
			if(!is_numeric($amount))continue;
					
			$ingredient = new Ingredient(trim($item), trim($amount), trim($unit));
			$fridgeIngredient = new FridgeIngredient($ingredient, trim($useByDate));
			array_push($this->fridgeIngredients, $fridgeIngredient);
		}
		fclose($frdgCsvHndlr);
	}

	private function readRecipeJsonFile($recipeJsonFile){
		$recipeJson = json_decode(file_get_contents($recipeJsonFile), true);
		if($recipeJson){
			$recipeName;
			$ingredientsRequired = array();
			foreach($recipeJson as $recipeCounter => $recipe){
				$recipeName = $recipeJson[$recipeCounter]['name'];
				$ingredients = $recipeJson[$recipeCounter]['ingredients'];
				$ingredientCollection = array();
				foreach($ingredients as $ingredientCounter => $ingredient){
					$item = $ingredients[$ingredientCounter]['item'];
					$amount = $ingredients[$ingredientCounter]['amount'];
					$unit = $ingredients[$ingredientCounter]['unit'];
					$ingredientObj = new Ingredient(trim($item), trim($amount), trim($unit));
					array_push($ingredientCollection, $ingredientObj);
				}
				
				$recipe = new Recipe($recipeName, $ingredientCollection);			
				array_push($this->recipes, $recipe);
			}
		}else{
			throw new Exception("Error: file format error, expecting JSON recipe file");
		}
	}
	//create function to check file format exception

}
