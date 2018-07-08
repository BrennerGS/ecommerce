<?php 

require_once("vendor/autoload.php");

use \Slim\slim;
use \Hcode\page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Products;

$app = new Slim();

$app->config('debug', true);


// Site Clientes 
require_once("site.php");


// Parte Administrativa
require_once("admin.php");
require_once("admin-categories.php");
require_once("admin-users.php");
require_once("admin-products.php");


$app->run();

 ?>



