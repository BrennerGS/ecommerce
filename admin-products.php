<?php

use \Slim\slim;
use \Hcode\page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Products;

$app->get("/admin/products", function(){

	User::verifyLogin();

	$products = Products::listAll();

	$page = new PageAdmin();


	$page->setTpl("products", array(
		"products"=>$products
	));

});

$app->get("/admin/products/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("products-create");

});

$app->post("/admin/products/create", function(){

	User::verifyLogin();

	$products = new Products();

	$products->setData($_POST);

	$products->save();

	header("Location: /admin/products");
	exit;

});

$app->get("/admin/products/:idproducts", function($idproducts){

	User::verifyLogin();

	$products = new Products();

	$products->get((int)$idproducts);

	$page = new PageAdmin();

	$page->setTpl("products-update", array(
		"product"=>$products->getValues()
	));

});

$app->post("/admin/products/:idproducts", function($idproducts){

	User::verifyLogin();

	$products = new Products();

	$products->get((int)$idproducts);

	$products->setData($_POST);

	$products->save();

	$products->setPhoto($_FILES["file"]);

	header("Location: /admin/products");
	exit;

});

$app->get("/admin/products/:idproducts/delete", function($idproducts){

	User::verifyLogin();

	$products = new Products();

	$products->get((int)$idproducts);

	$products->delete();

	header("Location: /admin/products");
	exit;

});



?>