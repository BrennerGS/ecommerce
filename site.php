<?php 

use \Slim\slim;
use \Hcode\page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Products;
use \Hcode\Model\Cart;

$app->get('/', function() {

	$products = Products::listAll();
    
	$page = new Page();

	$page->setTpl("index", array(
		"products"=>Products::checkList($products)
	));

});



$app->get("/categories/:idcategory", function($idcategory){
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();

	$category->get((int)$idcategory);
	
	$pagination = $category->getProductPage($page);

	$pages = [];

	for ($i=1; $i <=$pagination["pages"] ; $i++) { 
		array_push($pages, [
			'link'=>'/categories/'. $category->getidcategory()."?page=".$i,
			'page'=>$i
		]);
	}

	$page = new Page();

	$page->setTpl("category", array(
		"category"=>$category->getValues(),
		"products"=>$pagination["data"],
		"pages"=>$pages
	));
});


$app->get("/products/:desurl", function($desurl){
	
	$products = new Products();

	$products->getFromURL($desurl);

	$page = new Page();

	$page->setTpl("product-detail", array(
		"product"=>$products->getValues(),
		"categories"=>$products->getCategories()
	));

});


$app->get("/cart", function(){
	
	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart");

});


?>