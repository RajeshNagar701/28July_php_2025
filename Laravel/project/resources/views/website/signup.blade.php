@extends('website.layout.structure')


@section('content')
	<!-- Banner -->
	<section class="tm-banner">
		<!-- Flexslider -->
		<div class="flexslider flexslider-banner">
		  <ul class="slides">
		    <li>
			    <div class="tm-banner-inner">
					<h1 class="tm-banner-title">Your <span class="tm-yellow-text">Special</span> Tour</h1>
					<p class="tm-banner-subtitle">For Upcoming Holidays</p>
					<a href="#more" class="tm-banner-link">Signup Us</a>	
				</div>
				<img src="{{url('website/img/banner-3.jpg')}}" alt="Banner 3" />	
		    </li>		    
		  </ul>
		</div>	
	</section>
	
	<!-- white bg -->
	<section class="section-padding-bottom">
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title">Signup Us</h2></div>
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div>
			<div class="row">
				<!-- contact form -->
				<form action="{{url('/signup')}}" enctype="multipart/form-data" method="post" class="tm-contact-form">
					@csrf
					<div class="col-lg-12 col-md-12 tm-contact-form-input">
						<div class="form-group">
							<input type="text" name="name" id="contact_email" class="form-control" placeholder="Name" />
						</div>
						<div class="form-group">
							<input type="email" name="email" id="contact_email" class="form-control" placeholder="Email" />
						</div>
						<div class="form-group">
							<input type="password" name="password" id="contact_name" class="form-control" placeholder="Password" />
						</div>
						<div class="form-group">
							<p>Gender</p>
							Male :<input type="radio" name="gender" id="contact_name" Value="Male" />
							Female :<input type="radio" name="gender" id="contact_name" Value="Female" />
						</div>
						<div class="form-group">
							<p>Hobby</p>
							Cricket :<input type="checkbox" name="hobby[]" id="contact_name" Value="Cricket" />
							Hocky :<input type="checkbox" name="hobby[]" id="contact_name" Value="Hocky" />
							Football :<input type="checkbox" name="hobby[]" id="contact_name" Value="Football" />
						</div>
						<div class="form-group">
							<input type="file" name="image" id="contact_email" class="form-control"/>
						</div>
						<div class="form-group">
							<button class="tm-submit-btn" type="submit" name="submit">Signup</button> 
						</div>  
						
						<a href="login">If you already Register then Login Here</a>
					</div>
				</form>
			</div>			
		</div>
	</section>
@endsection