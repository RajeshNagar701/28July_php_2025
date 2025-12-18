

<?php

include_once('model.php');  // step 1 model load

class control extends model{  //  step 2 model class extends in control for functionalites use
	
	function __construct(){
	
		session_start();
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
			
			case '/signup':
				if(isset($_SESSION['uid']))
				{
					echo "<script>
					window.location='index';
					</script>";
				}
				else
				{
					$country_arr=$this->select('countries');
					if(isset($_REQUEST['submit']))
					{
						$name=$_REQUEST['name'];
						$email=$_REQUEST['email'];
						$password=md5($_REQUEST['password']);
						$gender=$_REQUEST['gender'];
						$hobby_arr=$_REQUEST['hobby'];
						$hobby=implode(",",$hobby_arr); //arr to string
						$cid=$_REQUEST['cid'];
						
						
						$image=$_FILES['image']['name'];
						if($_FILES['image']['size']>0)
						{
							$path="img/customer/".$image;  // path where we upload img
							$dup_file1=$_FILES['image']['tmp_name']; // get duplicate file
							move_uploaded_file($dup_file1,$path); // move dupl image in path
						}
						
						$arr=array("name"=>$name,"email"=>$email,"password"=>$password,"gender"=>$gender,"hobby"=>$hobby,"cid"=>$cid,"image"=>$image);
						
						$run=$this->insert('customers',$arr);
						if($run)
						{
							echo "customers Inserted Success";
						}
						else
						{
							echo "nOPT Success";
						}	
						
					}
					include_once('signup.php');
				}
			break;
			
			case '/login':
				if(isset($_SESSION['uid']))
				{
					echo "<script>
					window.location='index';
					</script>";
				}
				else
				{
					if(isset($_REQUEST['submit']))
					{
						$email=$_REQUEST['email'];
						$password=md5($_REQUEST['password']);
						
						$where=array("email"=>$email,"password"=>$password);
						
						$run=$this->select_where('customers',$where);
						$chk=$run->num_rows;
						if($chk==1) // 1 means true & 0 means false
						{
							$fetch=$run->fetch_object();
							if($fetch->status=="Unblock")
							{
								// sessiob_create
								$_SESSION['uname']=$fetch->name;
								$_SESSION['uid']=$fetch->uid;
								echo "<script>
								alert('Login Success');
								window.location='index';
								</script>";
							}
							else
							{
								echo "<script>
								alert('Login Failed due to Blocked Account');
								</script>";
							}
						}
						else
						{
							echo "<script>
							alert('Login Failed Due to Wrong Creadencial');
							</script>";
						}
						
					}
					include_once('login.php');
				}
			break;
			
			case '/cust_logout':
				// delete ssession
				unset($_SESSION['uname']);
				unset($_SESSION['uid']);
				echo "<script>
					alert('Logout Success');
					window.location='index';
					</script>";
			break;
			
			
			case '/profile':
				if(isset($_SESSION['uid']))
				{
					$where=array('uid'=>$_SESSION['uid']);
					$res=$this->select_where('customers',$where);
					$fetch=$res->fetch_object();         
					include_once('profile.php');
				}
				else
				{
					echo "<script>
					window.location='index';
					</script>";
				}
			break;
			
			case '/edit_profile':
				if(isset($_SESSION['uid']))
				{
					$country_arr=$this->select('countries');
					if(isset($_REQUEST['edit_cust']))
					{
						$uid=$_REQUEST['edit_cust'];
						$where=array('uid'=>$uid);
						$res=$this->select_where('customers',$where);
						$fetch=$res->fetch_object();  
						
						$old_image=$fetch->image;

						if(isset($_REQUEST['save']))
						{
							$name=$_REQUEST['name'];
							$email=$_REQUEST['email'];
							$gender=$_REQUEST['gender'];
							$hobby_arr=$_REQUEST['hobby'];
							$hobby=implode(",",$hobby_arr); //arr to string
							$cid=$_REQUEST['cid'];
							
							if($_FILES['image']['size']>0)
							{
								$image=$_FILES['image']['name'];
								$path="img/customer/".$image;  // path where we upload img
								$dup_file1=$_FILES['image']['tmp_name']; // get duplicate file
								move_uploaded_file($dup_file1,$path); // move dupl image in path
								
								$arr=array("name"=>$name,"email"=>$email,"gender"=>$gender,"hobby"=>$hobby,"cid"=>$cid,"image"=>$image);
							
								$res=$this->update('customers',$arr,$where);	
								if($res)
								{
									unlink('img/customer/'.$old_image);
									echo "<script>
										alert('Update Success');
										window.location='profile';
										</script>";
								}
							}
							else
							{
								$arr=array("name"=>$name,"email"=>$email,"gender"=>$gender,"hobby"=>$hobby,"cid"=>$cid);
								$res=$this->update('customers',$arr,$where);	
								if($res)
								{
									echo "<script>
										alert('Update Success');
										window.location='profile';
										</script>";
								}
							}
							
							
							
						
						}
								
					}
				}
				else
				{
					echo "<script>
					window.location='index';
					</script>";
				}
				include_once('edit_profile.php');
			break;
			
			
			case '/about':
				include_once('about.php');
			break;
			
				
			case '/shop':
				$cate_arr=$this->select('categories');
				
				if(isset($_REQUEST['submit']))
				{
					$cate_id=$_REQUEST['cate_id'];
					$where=array('cate_id'=>$cate_id,'status'=>"InStock");
					$res=$this->select_where('products',$where);
					while($fetch=$res->fetch_object())           // fetch all data which query generate
					{
						$prod_arr[]=$fetch;
					}
				}
				else
				{
					$where=array('status'=>"InStock");
					$res=$this->select_where('products',$where);
					while($fetch=$res->fetch_object())           // fetch all data which query generate
					{
						$prod_arr[]=$fetch;
					}
				}
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
				
				if(isset($_REQUEST['submit']))
				{
					$name=$_REQUEST['name'];
					$email=$_REQUEST['email'];
					$comment=$_REQUEST['comment'];
					
					$arr=array("name"=>$name,"email"=>$email,"comment"=>$comment);
					
					$run=$this->insert('contacts',$arr);
					if($run)
					{
						echo "Contact Submitted Success";
					}
					else
					{
						echo "nOPT Success";
					}	
					
				}
				include_once('contact.php');
			break;
		}
	}
	
}

$obj=new control;
?>