<?php

include_once('model.php');

class control extends model{
	
	
	function __construct(){
		
		$page_url=$_SERVER['PATH_INFO']; //http://localhost/students/10th_August_PHP_2024/basic_opps/MVC/control.php
		
		switch($page_url){
			
			case '/mypage':
			
				$regsister_data=$this->select('register');
				include_once('view_product.php');
			break;
			
		}
	}
}

$obj=new control;
?>