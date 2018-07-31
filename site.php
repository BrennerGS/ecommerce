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

	$page->setTpl("cart", [
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Cart::getMsgError()
	]);

});


$app->get("/cart/:idproduct/add", function($idproduct){

	$Products = new Products();

	$Products->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

	for ($i = 0; $i < $qtd; $i++) {
		
		$cart->addProduct($Products);

		

	}


	header("Location: /cart#prod_scroll");
	exit;

});


$app->get("/cart/:idproduct/minus", function($idproduct){

	$Products = new Products();

	$Products->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($Products);

	

	header("Location: /cart#prod_scroll");
	exit;

});

$app->get("/cart/:idproduct/remove", function($idproduct){

	$Products = new Products();

	$Products->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($Products, true);

	header("Location: /cart#prod_scroll");
	exit;
 
 });


$app->post("/cart/freight", function(){

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /cart#prod_scroll");
	exit;

 });


?>