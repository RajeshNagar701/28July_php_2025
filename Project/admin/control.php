

<?php

include_once('../website/model.php');  // step 1 model load

class control extends model{  //  step 2 model class extends in control for functionalites use
	
	function __construct(){
	
		model::__construct();	  // step 3 call model __construct
		
		$url=$_SERVER['PATH_INFO']; //http://localhost/students/01_Aug_PHP_2025/Project/website/control.php
		
		switch($url)
		{
			case '/admin-login':
				include_once('index.php');
			break;
			
			case '/dashboard':
				include_once('dashboard.php');
			break;
			
			case '/add_categories':
				include_once('add_categories.php');
			break;
			
			case '/manage_categories':
				include_once('manage_categories.php');
			break;
			
			case '/add_products':
				include_once('add_products.php');
			break;
			
			case '/manage_products':
				include_once('manage_products.php');
			break;
				
			case '/manage_contact':
				include_once('manage_contact.php');
			break;
			
			case '/manage_customer':
				include_once('manage_customer.php');
			break;
			
			case '/manage_cart':
				include_once('manage_cart.php');
			break;
			
			case '/manage_order':
				include_once('manage_order.php');
			break;
			
			case '/manage_feedback':
				include_once('manage_feedback.php');
			break;
		}
	}
	
}

$obj=new control;
?>