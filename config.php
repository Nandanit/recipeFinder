<?php

define('INCLUDE_PATH', dirname(__FILE__).'/'); 
define('EXPIRY_DATE_FORMAT' , 'd/m/Y');
define('UNIT_ENUM' , serialize(array('slices', 'ml', 'grams')));
include_once INCLUDE_PATH . 'sourcecode\ingredient\Unit.php';
include_once INCLUDE_PATH . 'sourcecode\ingredient\Ingredient.php';
include_once INCLUDE_PATH . 'sourcecode\ingredient\FridgeIngredient.php';
include_once INCLUDE_PATH . 'sourcecode\recipe\Recipe.php';
include_once INCLUDE_PATH . 'sourcecode\recipe\RecipeFinder.php';
date_default_timezone_set("Australia/Sydney"); 
?>