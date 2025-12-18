

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
				if(isset($_SESSION['a_id']))
				{
					echo "<script>
					window.location='dashboard';
					</script>";
				}
				else
				{
					if(isset($_REQUEST['submit']))
					{
						$email=$_REQUEST['email'];
						$password=$_REQUEST['password'];
						$enc_password=md5($password);
						
						$where=array("email"=>$email,"password"=>$enc_password);
						
						$run=$this->select_where('admins',$where);
						$chk=$run->num_rows;
						if($chk==1) // 1 means true & 0 means false
						{
							// create cookie
							if(isset($_REQUEST['rem']))
							{
								setcookie('c_email',$email,time()+15);  //(365*24*60*60)
								setcookie('c_password',$password,time()+15); 
							}
							
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
				}
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
			
			case '/delete':
				if(isset($_REQUEST['del_contact']))
				{
					$id=$_REQUEST['del_contact'];
					$where=array("id"=>$id);
					$res=$this->delete('contacts',$where);
					if($res){
						echo "<script>
						alert('Contact Delete Success');
						window.location='manage_contact';
						</script>";
					}
						
				}
				
				if(isset($_REQUEST['del_customer']))
				{
					
					$uid=$_REQUEST['del_customer'];
					$where=array("uid"=>$uid);
					
					//get delete image after delete
					$res=$this->select_where('customers',$where);
					$fetch=$res->fetch_object();
					$del_img=$fetch->image;
					
					$res=$this->delete('customers',$where);
					if($res){
						
						unlink('../website/img/customer/'.$del_img);
						echo "<script>
						alert('Customers Delete Success');
						window.location='manage_customer';
						</script>";
					}
				}
				
				if(isset($_REQUEST['del_cate']))
				{
					$cate_id=$_REQUEST['del_cate'];
					$where=array("cate_id"=>$cate_id);
					
					//get delete image after delete
					$res=$this->select_where('categories',$where);
					$fetch=$res->fetch_object();
					$cate_image=$fetch->cate_image;
					
					$res=$this->delete('categories',$where);
					if($res){
						
						unlink('assets/images/categories/'.$cate_image);
						echo "<script>
						alert('Categories Delete Success');
						window.location='manage_categories';
						</script>";
					}
				}
				
				if(isset($_REQUEST['del_prod']))
				{
					$pro_id=$_REQUEST['del_prod'];
					$where=array("pro_id"=>$pro_id);
					
					//get delete image after delete
					$res=$this->select_where('products',$where);
					$fetch=$res->fetch_object();
					$image=$fetch->image;
					
					$res=$this->delete('products',$where);
					if($res){
						
						unlink('assets/images/products/'.$image);
						echo "<script>
						alert('Product Delete Success');
						window.location='manage_products';
						</script>";
					}
				}
			break;
			
			case '/admin_status':
				if(isset($_REQUEST['status_customer']))
				{
					$uid=$_REQUEST['status_customer'];
					$where=array("uid"=>$uid);
					$res=$this->select_where('customers',$where);
					$fetch=$res->fetch_object();
					
					if($fetch->status=="Unblock")
					{
						$arr=array("status"=>"Block");
						$res=$this->update('customers',$arr,$where);	
						if($res)
						{
							echo "<script>
								alert('Status Block Success');
								window.location='manage_customer';
								</script>";
						}
					}
					else
					{
						$arr=array("status"=>"Unblock");
						$res=$this->update('customers',$arr,$where);	
						if($res)
						{
							echo "<script>
								alert('Status Unblock Success');
								window.location='manage_customer';
								</script>";
						}
					}
					
				}
				
				if(isset($_REQUEST['status_product']))
				{
					$pro_id=$_REQUEST['status_product'];
					$where=array("pro_id"=>$pro_id);
					$res=$this->select_where('products',$where);
					$fetch=$res->fetch_object();
					
					if($fetch->status=="InStock")
					{
						$arr=array("status"=>"OutofStock");
						$res=$this->update('products',$arr,$where);	
						if($res)
						{
							echo "<script>
								alert('Status OutofStock Success');
								window.location='manage_products';
								</script>";
						}
					}
					else
					{
						$arr=array("status"=>"InStock");
						$res=$this->update('products',$arr,$where);	
						if($res)
						{
							echo "<script>
								alert('Status InStock Success');
								window.location='manage_products';
								</script>";
						}
					}
					
				}
				
			break;
			
			
		}
	}
	
}

$obj=new control;
?>