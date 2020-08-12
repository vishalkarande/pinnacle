












<?php
session_start();
error_reporting(0);
include('include/config.php');








?>


<!DOCTYPE html>
<html lang="en">
	
	
	
	
	
	
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Kindle : Home</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="assets/images/favicon.ico"/>
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Slick slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">

    <!-- Main Style -->
    <link href="style.css" rel="stylesheet">

    <!-- Fonts -->

    <!-- Open Sans for body font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800" rel="stylesheet">
    <!-- Lato for Title -->
  	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"> 
 
 
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

   	
 	<header id="mu-header" class="" role="banner" style="background-color:#ff871c;">
		<div class="container" >
			<nav class="navbar navbar-default mu-navbar">
			  	<div class="container-fluid"  >
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>

				      <!-- Text Logo -->
	    <a class="navbar-brand" href="index.html"><img src="images/pinaccle.png" style="height:55px;width:120px"></a>

				      <!-- Image Logo -->
				      <!-- <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png"></a> -->


				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
				      	<ul class="nav navbar-nav mu-menu navbar-right">
					         <li><a href="index.php">HOME</a></li>
					        <li><a href="aboutus.php">ABOUT US</a></li>
					        <li><a href="book.php">BOOKS</a></li>
				            
				            <li><a href="contact.php">CONTACT</a></li>
				      	</ul>
				    </div><!-- /.navbar-collapse -->
			  	</div><!-- /.container-fluid -->
			</nav>
		</div>
	</header>
	<!-- End Header -->

	<!-- Start Featured Slider -->
	  
	  

	<!-- Start Featured Slider -->
	  
	  
	  
	  
	  
	  
	  
	  


		<!-- Start Book Overview -->
		<section id="mu-book-overview" style="padding-top:30px">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-book-overview-area">

							<div class="mu-heading-area">
								<h2 class="mu-heading-title">All Books</h2>
								<span class="mu-header-dot"></span>
								
								
								
								
								
								
								
								
								
								
								
								
							
								
								
								
								
								
								
								
											
								  	<!-- Start Header -->

		<div class="container" style=" float: left;" >
			<nav class="navbar navbar-default mu-navbar">
			  	<div class="container-fluid">
				    <!-- Brand and toggle get grouped for better mobile display -->
				     <div class="navbar-header" >
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false" style=" background-color: #1c1b1b;">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>

				      <!-- Text Logo -->
				    

				      <!-- Image Logo -->
				      <!-- <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png"></a> -->


				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2" >
				      	<ul class="nav navbar-nav mu-menu navbar-right" style=" background-color: #fc9547;">
					        <li><a href="book.php">All Books</a></li>
					        <li><a href="technicalbooks.php">Technical</a></li>
					        <li><a href="nontech.php">Non-Technical</a></li>
				            <li><a href="#mu-pricing">Magzines</a></li>
				            <li><a href="#mu-testimonials">News Letters</a></li>
				          
				      	</ul>
				    </div><!-- /.navbar-collapse -->
			  	</div><!-- /.container-fluid -->
			</nav>
		</div>

								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
							</div>

							<!-- Start Book Overview Content -->
							<div class="mu-book-overview-content" >
								<div class="row">
										<?php
												
												$ret=mysqli_query($con,"select * from books ");
												
	
												
															while($row=mysqli_fetch_array($ret)){
		
		
		
														
												
												
												?>

									<!-- Book Overview Single Content -->
									<div class="col-md-3 col-sm-6">
										<div class="mu-book-overview-single" style="padding-top:20px;height: 500px">
											
												<img src="images/books/<?php  echo htmlentities($row['image_name']); ?>" style="height:350px;width:250px">
												
											
												
												
												
												
												
												
										
											<h4>	
											<?php	echo htmlentities($row['name']);
												
												
												?>
											
											
											</h4>
											<p>		<?php	echo htmlentities($row['discription']);
												
												
												?></p>
										</div>
									</div>
									<!-- / Book Overview Single Content -->
									
									<?php } ?>

									

								</div>
							</div>
							<!-- End Book Overview Content -->

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Book Overview -->

		

	
	
	<!-- End main content -->	
			
			
	<!-- Start footer -->
	<footer id="mu-footer" role="contentinfo">
		<div class="container">
			<div class="mu-footer-area">
				<div class="mu-social-media">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-google-plus"></i></a>
					<a href="#"><i class="fa fa-linkedin"></i></a>
				</div>
				<p class="mu-copyright">&copy; Copyright <a rel="nofollow" href="http://markups.io">markups.io</a>. All right reserved.</p>
			</div>
		</div>

	</footer>
	<!-- End footer -->

	
	
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
	<!-- Slick slider -->
    <script type="text/javascript" src="assets/js/slick.min.js"></script>
    <!-- Counter js -->
    <script type="text/javascript" src="assets/js/counter.js"></script>
    <!-- Ajax contact form  -->
    <script type="text/javascript" src="assets/js/app.js"></script>
   
 
	
    <!-- Custom js -->
	<script type="text/javascript" src="assets/js/custom.js"></script>
	
    
  </body>
</html>

