<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\slim;

use \Hcode\page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Products;
use \Hcode\Model\Cart;
use \Hcode\Model\Address;


$app = new Slim();

$app->config('debug', true);

$app->get('/api', function() {

	$products = Products::listAll();
    
	var_dump(json_encode($products));

});

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



