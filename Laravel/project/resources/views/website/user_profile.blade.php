@extends('website.layout.structure')


@section('content')
<!-- Banner -->
<section class="tm-banner">
	<!-- Flexslider -->
	<div class="flexslider flexslider-banner">
		<ul class="slides">
			<li>
				<div class="tm-banner-inner">
					<h1 class="tm-banner-title">Find <span class="tm-yellow-text">The Best</span> Place</h1>
					<p class="tm-banner-subtitle">For Your Holidays</p>
					<a href="#more" class="tm-banner-link">Learn More</a>
				</div>
				<img src="{{url('website/img/banner-1.jpg')}}" alt="Image" />
			</li>
			<li>
				<div class="tm-banner-inner">
					<h1 class="tm-banner-title">Lorem <span class="tm-yellow-text">Ipsum</span> Dolor</h1>
					<p class="tm-banner-subtitle">Wonderful Destinations</p>
					<a href="#more" class="tm-banner-link">Learn More</a>
				</div>
				<img src="{{url('website/img/banner-2.jpg')}}" alt="Image" />
			</li>
			<li>
				<div class="tm-banner-inner">
					<h1 class="tm-banner-title">Proin <span class="tm-yellow-text">Gravida</span> Nibhvell</h1>
					<p class="tm-banner-subtitle">Velit Auctor</p>
					<a href="#more" class="tm-banner-link">Learn More</a>
				</div>
				<img src="{{url('website/img/banner-3.jpg')}}" alt="Image" />
			</li>
		</ul>
	</div>
</section>



<!-- white bg -->
<section class="tm-white-bg section-padding-bottom">
	<div class="container">
		<div class="row">
			<div class="tm-section-header section-margin-top">
				<div class="col-lg-4 col-md-3 col-sm-3">
					<hr>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<h2 class="tm-section-title">User Profile</h2>
				</div>
				<div class="col-lg-4 col-md-3 col-sm-3">
					<hr>
				</div>
			</div>
			<div class="offset-lg-2 col-lg-6">
				<div class="row">
					<div class="col-lg-5">
						<div class="tm-home-box-3-img-container">
							<img src="{{url('upload/customer/'.$data->image)}}" alt="image" class="img-responsive">
						</div>
					</div>
					<div class="col-lg-7">
						<p class=""><b>Customer ID : </b>{{$data->id}}</p>
						<p class=""><b>Name : </b>{{$data->name}}</p>
						<p class=""><b>Email : </b>{{$data->email}}</p>
						<p class=""><b>Gender : </b>{{$data->gender}}</p>
						<p class=""><b>Hobby : </b>{{$data->hobby}}</p>
						<div class="">
							
							<a href="{{url('/user_profile/'.$data->id)}}" class="tm-home-box-2-link"><span class="tm-home-box-2-description box-3">Edit Profile <i class="fa fa-edit tm-home-box-2-icon border-right"></i> </span></a>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection