	<?php
	include_once('header.php');
	?>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>Profile</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="./index.php">Home</a>
                        <span>Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->



    <!-- Team Section Begin -->
    <section class="team spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <div class="section-title">
                        <span>My Profile</span>
                        <h2><?php echo $fetch->name;?></h2>
						<h4>Email :<?php echo $fetch->email;?></h4>
						<h4>Gender :<?php echo $fetch->gender;?></h4>
						<h4>Hobby :<?php echo $fetch->hobby;?></h4>
						<div class="team__btn">
							<a href="edit_profile?edit_cust=<?php echo $fetch->uid;?>" class="primary-btn">Edit Profile</a>
						</div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <img src="img/customer/<?php echo $fetch->image;?>" width="100%" />
                </div>
            </div>
         
        </div>
    </section>
    <!-- Team Section End -->
<?php
   include_once('footer.php');
   ?>