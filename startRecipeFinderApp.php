<?php

include "config.php";
$recipeFinder = new RecipeFinder($argv[1], $argv[2]);
$commendedRecipe = $recipeFinder->recommendRecipe();
echo $commendedRecipe;

?>
