<?php
	include_once('header.php');
	?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            
            
            <div class="row">
                
                <div class=" offset-lg-2 col-lg-8">
					 <h3 align="center" class="mb-5">Signup In Here</h3>
                    <div class="">
                        <form action="" method="post"  enctype="multipart/form-data">
                            <div class="row">
								<div class="col-lg-12 m-2">
                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                </div>
                                <div class="col-lg-12 m-2">
                                    <input type="text" class="form-control"  name="email" placeholder="Email">
                                </div>
								<div class="col-lg-12 m-2">
                                    <input type="password" class="form-control"  name="password" placeholder="Password">
                                </div>
								<div class="col-lg-12 m-2">
									Gender : <br>
                                    Male :<input type="radio" name="gender" value="Male">
									Female :<input type="radio"  name="gender" value="Female">
                                </div>
								<div class="col-lg-12 m-2">
									Hobby : <br>
                                    Cricket :<input type="checkbox" name="hobby[]" value="Cricket">
									Hockky :<input type="checkbox"  name="hobby[]" value="Hockky">
									BaseBoll :<input type="checkbox"  name="hobby[]" value="BaseBoll">
                                </div>
								<div class="col-lg-12 m-2">
                                    <select class="form-control" name="cid">
										<option value="">Select Country</option>
										<?php
										foreach($country_arr as $data)
										{
										?>
											<option value="<?php echo $data->cid?>">
															<?php echo $data->cnm?>
											</option>
										<?php
										}
										?>
									</select>
                                </div>
								<div class="col-lg-12 m-2">
                                    <input type="file" class="form-control"  name="image" placeholder="image">
                                </div>
					
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" class="site-btn">Sign In </button>
                                </div>
								<div class="col-lg-12 mt-5">
                                    <a href="login">If you already Registred Then Login Here </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
<?php
   include_once('footer.php');
   ?>