<?php
	include_once('header.php');
	?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            
            
            <div class="row">
                
                <div class=" offset-lg-2 col-lg-8">
					 <h3 align="center" class="mb-5">Edit Profile</h3>
                    <div class="">
                        <form action="" method="post"  enctype="multipart/form-data">
                            <div class="row">
								<div class="col-lg-12 m-2">
                                    <input type="text" class="form-control" value="<?php echo $fetch->name; ?>" name="name" placeholder="Name">
                                </div>
                                <div class="col-lg-12 m-2">
                                    <input type="text" class="form-control" value="<?php echo $fetch->email; ?>"  name="email" placeholder="Email">
                                </div>
								
								<?php
								$gender=$fetch->gender;
								?>
								<div class="col-lg-12 m-2">
									Gender : <br>
                                    Male :<input type="radio" name="gender" value="Male" <?php if($gender=="Male"){ echo "checked";}?>>
									Female :<input type="radio"  name="gender" value="Female" <?php if($gender=="Female"){ echo "checked";}?>>
                                </div>
								
								
								
								<?php
								$hobby=$fetch->hobby; //Cricket,Hockky
								$hobby_arr=explode(",",$hobby); // array("0"=>"Cricket","1"=>"Hockky");
								?>
								<div class="col-lg-12 m-2">
									Hobby : <br>
                                    Cricket :<input type="checkbox" name="hobby[]" value="Cricket" <?php if(in_array("Cricket",$hobby_arr)){echo "checked";}?>>
									Hockky :<input type="checkbox"  name="hobby[]" value="Hockky" <?php if(in_array("Hockky",$hobby_arr)){echo "checked";}?>>
									BaseBoll :<input type="checkbox"  name="hobby[]" value="BaseBoll" <?php if(in_array("BaseBoll",$hobby_arr)){echo "checked";}?>>
                                </div>
								<div class="col-lg-12 m-2">
                                    <select class="form-control" name="cid">
										<option value="">Select Country</option>
										<?php
										foreach($country_arr as $data)
										{
											if($data->cid==$fetch->cid)
											{
										?>
											<option value="<?php echo $data->cid?>" selected>
															<?php echo $data->cnm?>
											</option>
										<?php
											}
											else
											{
											?>
											<option value="<?php echo $data->cid?>">
															<?php echo $data->cnm?>
											</option>
										<?php		
											}
										}
										?>
									</select>
                                </div>
								<div class="col-lg-12 m-2">
                                    <input type="file" class="form-control"  name="image" placeholder="image">
									<img src="img/customer/<?php echo $fetch->image;?>" width="100px" />
								</div>
					
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" class="site-btn">Save</button>
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