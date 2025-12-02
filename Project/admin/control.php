

<?php

include_once('../website/model.php');  // step 1 model load

class control extends model{  //  step 2 model class extends in control for functionalites use
	
	function __construct(){
	
		model::__construct();	  // step 3 call model __construct
		session_start();
		$url=$_SERVER['PATH_INFO']; //http://localhost/students/01_Aug_PHP_2025/Project/website/control.php
		
		switch($url)
		{
			case '/admin-login':
				if(isset($_REQUEST['submit']))
				{
					
					$email=$_REQUEST['email'];
					$password=md5($_REQUEST['password']);
					
					$where=array("email"=>$email,"password"=>$password);
					
					$run=$this->select_where('admins',$where);
					$chk=$run->num_rows;
					if($chk==1) // 1 means true & 0 means false
					{
						$fetch=$run->fetch_object();
						// sessiob_create
						$_SESSION['a_name']=$fetch->a_name;
						$_SESSION['a_id']=$fetch->id;
					
						echo "<script>
						alert('Login Success');
						window.location='dashboard';
						</script>";
					}
					else
					{
						echo "<script>
						alert('Login Failed');
						</script>";
					}
					
				}
				include_once('index.php');
			break;
			
			case '/admin_logout':
				// delete ssession
				unset($_SESSION['a_name']);
				unset($_SESSION['a_id']);
				echo "<script>
					alert('Logout Success');
					window.location='admin-login';
					</script>";
			break;
			
			case '/dashboard':
				include_once('dashboard.php');
			break;
			
			case '/add_categories':
				
				if(isset($_REQUEST['submit']))
				{
					$cate_name=$_REQUEST['cate_name'];
					
					$cate_image=$_FILES['cate_image']['name'];
					if($_FILES['cate_image']['size']>0)
					{
						$path="assets/images/categories/".$cate_image;  // path where we upload img
						$dup_file1=$_FILES['cate_image']['tmp_name']; // get duplicate file
						move_uploaded_file($dup_file1,$path); // move dupl image in path
					}
					
					$arr=array("cate_name"=>$cate_name,"cate_image"=>$cate_image);
					
					$run=$this->insert('categories',$arr);
					if($run)
					{
						echo "categories Inserted Success";
					}
					else
					{
						echo "nOPT Success";
					}	
					
				}
				include_once('add_categories.php');
			break;
			
			case '/manage_categories':
				$cate_arr=$this->select('categories');
				include_once('manage_categories.php');
			break;
			
			case '/add_products':
				if(isset($_REQUEST['submit']))
				{
					$cate_id=$_REQUEST['cate_id'];
					$title=$_REQUEST['title'];
					$price=$_REQUEST['price'];
					$description=$_REQUEST['description'];
					
					$image=$_FILES['image']['name'];
					if($_FILES['image']['size']>0)
					{
						$path="assets/images/products/".$image;  // path where we upload img
						$dup_file1=$_FILES['image']['tmp_name']; // get duplicate file
						move_uploaded_file($dup_file1,$path); // move dupl image in path
					}
					
					$arr=array("cate_id"=>$cate_id,"title"=>$title,"price"=>$price,"description"=>$description,"image"=>$image);
					
					$run=$this->insert('products',$arr);
					if($run)
					{
						echo "products Inserted Success";
					}
					else
					{
						echo "nOPT Success";
					}	
					
				}
				$cate_arr=$this->select('categories');
				include_once('add_products.php');
			break;
			
			case '/manage_products':
				$prod_arr=$this->select('products');
				include_once('manage_products.php');
			break;
				
			case '/manage_contact':
				$cont_arr=$this->select('contacts');
				include_once('manage_contact.php');
			break;
			
			case '/manage_customer':
				$cust_arr=$this->select('customers');
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