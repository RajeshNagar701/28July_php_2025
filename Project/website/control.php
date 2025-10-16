

<?php

include_once('model.php');  // step 1 model load

class control extends model{  //  step 2 model class extends in control for functionalites use
	
	function __construct(){
	
		model::__construct();	  // step 3 call model __construct
		
		$url=$_SERVER['PATH_INFO']; //http://localhost/students/01_Aug_PHP_2025/Project/website/control.php
		
		
		switch($url)
		{
			case '/':
				include_once('index.php');
			break;
			
			case '/index':
				include_once('index.php');
			break;
			
			case '/about':
				include_once('about.php');
			break;
			
				
			case '/shop':
				$this->select('product');
				include_once('shop.php');
			break;
			
				
			case '/shop-details':
				include_once('shop-details.php');
			break;
			
				
			case '/shoping-cart':
				include_once('shoping-cart.php');
			break;
			
				
			case '/checkout':
				include_once('checkout.php');
			break;
			
				
			case '/wisslist':
				include_once('wisslist.php');
			break;
			
				
			case '/blog-details':
				include_once('blog-details.php');
			break;
			
			case '/blog':
				include_once('blog.php');
			break;
			
			case '/contact':
				echo "hello";
				include_once('contact.php');
			break;
		}
	}
	
}

$obj=new control;
?>