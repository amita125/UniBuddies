<?php  
	
include("includes/config.php"); 

	if (isset($_SESSION['username'])) {
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
		
	}
	else {
		header("Location: admin_register.php");
	}

?>

<!doctype html>
<html lang="en">
  <head>
 	<title> Welcome to UniBuddies! </title>
		<!--Stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="84-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="../assets/css/style.css">
		<link rel="stylesheet" href="../assets/css/responsive.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

		<!-- Javascript -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="../assets/js/bootbox.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="../assets/js/demo.js"></script>
	</head>
	<body>
   
<div class="theme-layout">
		<!-- div container to wrap top navigation -->
		<div class="mynav ">
			<!-- Navigation start -->
			<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-light ">
			
				
				<!-- logo  -->

				<a class="navbar-brand" href="index.php"><img src="../assets/images/backgrounds/logo.png"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- logo end   -->

				<!--start of responsive navigation bar  -->
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					
					<!-- start of navigation right  -->
					<ul class="navbar-nav justify-content-end"></ul>
						

					    <span class="navbar-text">
					    	<!-- navigation right icons -->
							<ul class="navbar-nav mr-auto">
								<!-- home icon  -->					
								<li class="nav-item active">
									<a class="nav-link" href="index.php">
										<i class="fa fa-home fa-lg"style="color:#82ccdd;"></i> 
										<span class="sr-only">(current)</span>
									</a>
									<br>
								</li>

								

								<!-- logout icon -->
								<li class="nav-item">
									<a class="nav-link" href="logout.php">
										<i class="fa fa-sign-out-alt  fa-lg"style="color:#82ccdd"></i>
									</a>
									<br>
								</li>
							</ul>
							<!-- end of navigation icons -->
						</span>
					</ul>
					<!-- end of navigation right -->
				</div>
				<!-- end of responsive navigation bar -->
				
			</nav>
			<!-- end navigation-->
			

		</div>
		<!-- end of top navigation -->
	</div>

<section>