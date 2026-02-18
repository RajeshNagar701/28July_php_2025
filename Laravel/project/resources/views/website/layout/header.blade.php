

<?php
	function active($currect_page){
	  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ; // current page url
	  $url = end($url_array);  // tours 
	  if($currect_page == $url){
		  echo 'active'; //class name in css 
	  } 
	}
	?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Holiday - templatemo</title>
<!--
Holiday Template
http://www.templatemo.com/tm-475-holiday
-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700' rel='stylesheet' type='text/css'>
  <link href="{{url('website/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{url('website/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{url('website/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">  
  <link href="{{url('website/css/flexslider.css')}}" rel="stylesheet">
  <link href="{{url('website/css/templatemo-style.css')}}" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  
  <body class="tm-gray-bg">

  @include('sweetalert::alert')
  	<!-- Header -->
  	<div class="tm-header">
  		<div class="container">
  			<div class="row">
  				<div class="col-lg-3 col-md-3 col-sm-3 tm-site-name-container">
  					<a href="#" class="tm-site-name">Holiday</a>	
  				</div>
	  			<div class="col-lg-9 col-md-9 col-sm-9">
	  				<div class="mobile-menu-icon">
		              <i class="fa fa-bars"></i>
		            </div>
	  				<nav class="tm-nav">
						<ul>
							<li><a href="index" class="<?php active('index')?>">Home</a></li>
							<li><a href="about" class="<?php active('about')?>">About</a></li>
							<li><a href="tours" class="<?php active('tours')?>">Our Tours</a></li>
							<li><a href="contact" class="<?php active('contact')?>">Contact</a></li>
							@if(session('user_id'))
							<li><a href="user_logout">Logout</a></li>
							@else
							<li><a href="login" class="<?php active('login')?>">Login</a></li>
							@endif
						</ul>
					</nav>		
	  			</div>				
  			</div>
  		</div>	  	
  	</div>
	