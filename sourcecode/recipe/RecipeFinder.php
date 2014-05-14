<?php

//class that reads input csv and JSON file and recommend a suitible recipe
final class RecipeFinder{

	//attributtes
	private $fridgeCsvFile;
	private $recipeJsonFile;
	private $fridgeIngredients = array();
	private $recipes = array();
	
	//class constructor
	public function __construct($fridgeCsvFile, $recipeJsonFile){
		$this->fridgeCsvFile = $fridgeCsvFile;
		$this->recipeJsonFile = $recipeJsonFile;
		$this->readFridgeCsvFile($this->fridgeCsvFile);
		$this->readRecipeJsonFile($this->recipeJsonFile);
	}

	//logic to recommend recipe based on requirement in test. 
	//Currently assuming fridge list csv file cannot contain multiple entries of same item. Works for provided sample
	public function recommendRecipe(){
		$recommendedRecipe = null;
		$recipeExpiry = null;
		for($rcpCounter=0;$rcpCounter<count($this->recipes);$rcpCounter++){
			$currentRecipe = $this->recipes[$rcpCounter];
			$ingredientsRequired = $currentRecipe->getingredients();
			list($ingredientAvailableToMakeRecipe, $recipeExpiryDate) =  $this->areIngredientsInFridge($ingredientsRequired);	
			if($ingredientAvailableToMakeRecipe){
				if(is_null($recipeExpiry)){
					$recommendedRecipe = $currentRecipe->getName();
					$recipeExpiry = $recipeExpiryDate;
				}else if($recipeExpiryDate < $recipeExpiry){
					$recommendedRecipe = $currentRecipe->getName();
					$recipeExpiry = $recipeExpiryDate;
				}
			}
		}
		
		if(is_null($recommendedRecipe)){
			return "Order Takeout";
		}
		
		return $recommendedRecipe;
	}
	
	//check fridge to see if ingredients are available to make a recipe
	private function areIngredientsInFridge($ingredientsRequiredForRecipe){
		$recipeExpireDate = null;
		for($i=0;$i<count($ingredientsRequiredForRecipe);$i++){
			$ingrdntInFrdge = false;		
			$ingredient = $ingredientsRequiredForRecipe[$i]; //required for recipe
			$ingredientRequiredForRecipe = $ingredient->getItem();
			$ingredientAmtRequiredForRecipe = $ingredient->getAmount();
			for($m=0;$m<count($this->fridgeIngredients);$m++){
				$currentFrdgIngrdnt = $this->fridgeIngredients[$m];
				$currentFrdgIngrdntName = $currentFrdgIngrdnt->getIngredient()->getItem();
				$currentFrdgIngrdntAmt = $currentFrdgIngrdnt->getIngredient()->getAmount();
				$currentFrdgIngrdntUseByDate = $currentFrdgIngrdnt->getUseByDate();
				if($ingredientRequiredForRecipe != $currentFrdgIngrdntName){
					continue;
				}else{
					if($ingredientAmtRequiredForRecipe <= $currentFrdgIngrdntAmt  && !$currentFrdgIngrdnt->isExpired()){
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
			}
			
			if($ingrdntInFrdge){
				continue;
			}else{
				return array(false, null);
			}
		}
		return array(true, $recipeExpireDate);
	}
	
	//parse fridge csv file and set fridge ingredients available 
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

	//parse recipie JSON file and set recipes available 
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
}
