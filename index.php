<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\slim;



$app = new Slim();

$app->config('debug', true);


// Site Clientes 
require_once("site.php");
require_once("function.php");


// Parte Administrativa
require_once("admin.php");
require_once("admin-categories.php");
require_once("admin-users.php");
require_once("admin-products.php");


$app->run();

 ?>



