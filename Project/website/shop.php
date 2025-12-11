<?php
	include_once('header.php');
	?>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>Shop</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="index">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="shop__option">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="shop__option__search">
                            <form action="" method="post">
                                <select name="cate_id">
										<option value="">
												All Cake
										</option>
									<?php
									foreach($cate_arr as $data)
									{
									?>
											<option value="<?php echo $data->cate_id?>">		
												<?php echo $data->cate_name?>
											</option>
									<?php
									}
									?>
                                </select>
                               
                                <button type="submit" name="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="row">
                
				<?php
				foreach($prod_arr as $data)
				{
				?>
				<div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="../admin/assets/images/products/<?php echo $data->image?>">
                            <div class="product__label">
                                <span><?php echo $data->title?></span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#"><?php echo $data->title?></a></h6>
                            <div class="product__item__price">$<?php echo $data->price?></div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
				}
				?>
               
            </div>
           
        </div>
    </section>
    <!-- Shop Section End -->
<?php
   include_once('footer.php');
   ?>