<?php
$active_tab = 'Home';
require_once('header.php');
require_once('menu.php');
$sliders = $QueryFire->getAllData('sliders',' is_show=1');
$adSliders = $QueryFire->getAllData('ad_sliders',' is_show=1');
$testimonials = $QueryFire->getAllData('testimonials',' is_show=1 limit 6');
$clients = $QueryFire->getAllData('clients',' is_show=1 order by id ');
//$products = $QueryFire->getAllData('products',' ','SET @I=0; SET @C=""; SELECT id,name, cat_id,slug,image_name FROM ( SELECT B.*, IF(@C != B.cat_id, @I:=1, @I:=@I+1) AS RowNum, @C:=B.cat_id FROM ( SELECT id, name, cat_id,slug,image_name FROM products WHERE is_show=1 and qty>0 and is_deleted=0 and trendings=1 GROUP BY cat_id ORDER BY cat_id limit 20 ) AS B HAVING RowNum <= 3 ) AS A');
if(!empty($sliders)) { ?>
<div class="slider-area">
	<div class="slider-active owl-dot-style owl-carousel">
		<?php foreach($sliders as $slider) { ?>
			<div class="single-slider">
			    <img src="<?= base_url.'images/sliders/'.$slider['image_name'] ?>" alt="Slider Image" />
			</div>
		<?php } ?>
	</div> 
</div>
<?php } ?>
<div class="product-area mt-40">
    <div class="custom-container">
        <div class="banner-area">
            <div class="row">
               <div class="col-md-3 col-sm-3 col-xs-12"></div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                   <form action="<?= base_url?>products" name="search_product" method="post">
                        <div class="input-group">
                            <input type='text' required class="form-control search_input" name="search" minlength='3' placeholder="Search for products" value="<?= isset($_POST['search'])?$_POST['search']:'' ?>" />
                            <span class="input-group-addon search"><i class="fa fa-search"></i></span>
                        </div>
                    </form>
               </div>
               <div class="col-md-3 col-sm-3 col-xs-12"></div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($adSliders)) { ?>
<div class="banner-area mt-40">
    <div class="container">
	    <div class="slider-active owl-dot-style owl-carousel">
		<?php foreach($adSliders as $slider) { ?>
			<div class="single-slider discount-overlay" >
			    <img src="<?= base_url.'images/sliders/'.$slider['image_name'] ?>" alt="Slider Image">
			</div>
		<?php } ?>
	</div> 
	</div>
</div>
<?php } if(!empty($categories)) { ?>
	<div class="product-area mt-40">
		<div class="custom-container">
           <div class="product-tab-list-wrap text-center mb-40">
              <div class="product-tab-list">
              	<div class="row">
					<?php foreach($categories as $cat) { ?>
						<div class="col-md-4 col-sm-4 col-6">
							<div class="product-wrapper mb-25">
								<div class="product-img">
									<a href="<?= base_url.'category/'.$cat['slug']?>">
										<img src="<?= base_url.'images/categories/'.$cat['image_name']?>" alt="product_image">
									</a>
								</div>
                                <div class="product-content">
                                    <h4>
                                        <a href="<?= base_url.'category/'.$cat['slug']?>"><?= $cat['name']?></a>
                                    </h4>
                                </div>
							</div>
						</div>
					<?php } ?>
				</div>
              </div>
           </div>
		</div>
	</div>
<?php } if(!empty($testimonials)){?>
    <style>
        .testimonial-4-img{
            border: 1px solid rgba(180,180,180,0.7) !important;
            padding: 20px;
        }
    </style>
	<div class="testimonials-area-4 mt-40 mb-40">
	    <div class="container">
	        <div class=" text-center">
              <h3 class="mt-30 mb-20"><strong>Testimonials</strong></h3>
           </div>
		    <div class="testimonial-2-active owl-dot-style owl-carousel">
			<?php foreach($testimonials as $testimonial) { ?>
				<div class="testimonial-2-wrapper" >
			        <div class="testimonial-4-img">
			            <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="testimonial-2-img">
                                    <img src="<?php echo base_url.'/images/testimonials/'.$testimonial['image_name']?>" alt="<?php echo $testimonial['name']?>" class="img-responsive img-thumbnail" />
                                    <h4 class="mt-10 text-center"><?php echo ucwords(strtolower($testimonial['name']))?></h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <h5><strong><?php echo $testimonial['title']?></strong></h5>
                              <p class="testimonial-content text-justify">
                                <?= makeShortString($testimonial['opinion'],280) ?>
                              </p>
                            </div>
                        </div>
			        </div>
				</div>
			<?php } ?>
			</div> 
		</div>
	</div>
<?php } if($clients){ ?>
<style>
    .brand-logo-active img {
        height:90px;
    }
</style>
<div class="brand-logo-area bg-light pt-20 pb-40">
  <div class="container">
      <div class=" text-center">
          <h3 class="mb-20"><strong>Our Partners</strong></h3>
       </div>
    <div class="brand-logo-active owl-carousel owl-loaded owl-drag">
        <?php foreach($clients as $client) { ?>
			<div class="item" >
                <img src="<?php echo base_url.'/images/clients/'.$client['image_name']?>" alt="<?php echo $client['name']?>" class="img-responsive img-thumbnail" />
			</div>
		<?php } ?>
	</div>
  </div>
<?php } require_once('footer.php'); ?>
<script>
    jQuery('.search').on('click',function() {
        if(jQuery('.search_input').val().length > 2)
            document.search_product.submit();
        jQuery('.search_input').focus();
    });
    $('.brand-logo-active').owlCarousel({
    margin:10,
    loop: true,
    nav:false,
    autoplay: true,
    autoplayTimeout: 6000,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    responsive:{
        0:{
            items:3
        },
        600:{
            items:5
        },
        1000:{
            items:9
        }
    }
})
</script>