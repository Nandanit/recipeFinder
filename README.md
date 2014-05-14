

Recipe Finder Application Usage
-------------------------------

1. Download GitHib

2. Extract content to recipeFinder-master

3. Navigate to recipeFinder-master\recipeFinder-master

4. Run command: php startRecipeFinderApp.php fridge.csv recipe.json.txt 
			or
	Double click: runRecipeFinder.bat


Sample fridge CSV provided:

bread,10,slices,25/12/2014 
cheese,10,slices,25/12/2014 
butter,250,grams,25/12/2014 
peanut butter,250,grams,2/12/2014 
mixed salad,500,grams,26/12/2013


Sample recipes provided:

[ 
	{ 
		"name": "grilled cheese on toast", 
		"ingredients": [ 
							{ "item":"bread", "amount":"2", "unit":"slices"}, 
							{ "item":"cheese", "amount":"2", "unit":"slices"} 
						] 
	} 
	, 
	{ 
		"name": "salad sandwich", 
		"ingredients": [ 
							{ "item":"bread", "amount":"2", "unit":"slices"}, 
							{ "item":"mixed salad", "amount":"200", "unit":"grams"} 
						] 
	} 
] 
	

Expected output based on current date:

grilled cheese on toast



Unit Test:

PHPUnit is being used for unit tests. Unit test file are located in recipeFinder-master\recipeFinder-master\phpUnitTest

1. Navigate to recipeFinder-master\recipeFinder-master\phpUnitTest

2. Run command: phpunit UnitTest fileTest.php

	e.g phpunit UnitTest RecipeFinderTest.php


	
	
Note: installtion of PHPUnit and PHP is needed




