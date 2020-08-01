<?php  
	require 'connection/connection.php';
	include("includes/classes/Student.php");
	include("includes/classes/Post.php");
	include("includes/classes/Message.php");
	include("includes/classes/Notification.php");
	include("includes/classes/Forum.php");
	include("includes/classes/Group.php");

	if (isset($_SESSION['student_name'])) {
		$studentLogIn = $_SESSION['student_name'];
		$student_query = mysqli_query($connection, "SELECT * FROM students WHERE student_name='$studentLogIn'");
		$student = mysqli_fetch_array($student_query);
	}
	else {
		header("Location: register.php");
	}
?>

<html>
	<head>
		<title> Welcome to UniBuddies! </title>
		<!--Stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="84-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

		<!-- Javascript -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="assets/js/bootbox.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!--<script src="assets/js/demo.js"></script>-->
	</head>
	<body>
	<div class="theme-layout">
		<!-- div container to wrap top navigation -->
		<div class="mynav ">
			<!-- Navigation start -->
			<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-light ">
				<?php
					//Unread messages 
					$messages = new Message($connection, $studentLogIn);
					$num_messages = $messages->getUnreadNumber();
					
					//Unread notification
					$notifications = new Notification($connection, $studentLogIn);
					$num_notifications = $notifications->getUnreadNumber();
				?>
				<!-- logo  -->
				<a class="navbar-brand" href="index.php"><img src="assets/images/backgrounds/logo.png"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- logo end   -->
				<!--start of responsive navigation bar  -->
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Search input form  -->
					<div class="search">
						<form class="form-inline" action="search.php"method="POST">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name = "query">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
						</form>
					</div>
					<!-- end of search form  -->
					<!-- start of navigation right  -->
					<ul class="navbar-nav justify-content-end"></ul>
						<!-- user image which is same as the profile image  -->
						<div class="user-img">
							<a class="nav-link" href="<?php echo $studentLogIn; ?>">  <img src="<?php echo $student['profile_pic']; ?>"> </a>
						</div>
						<!-- end of user image -->
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
								<!--notification icon   -->
								<li class="nav-item">
									<a class="nav-link" href="notification.php">
										<i class="fas fa-bell fa-lg"style="color:#82ccdd;"></i>
										<?php
											if($num_notifications > 0)
												echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
										?>
									</a>
									<br>
								</li>
								<!-- message icon -->
								<li class="nav-item">
									<a class="nav-link"href="msgnoti.php">
										<i class="fas fa-envelope fa-lg"style="color:#82ccdd;"></i>
										<?php
											if($num_messages > 0)
												echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
										?>
									</a>
									<br>
								</li>
								<!-- friends icon -->
								<li class="nav-item">
									<a class="nav-link" href="requests.php">
										<i class="fa fa-user-cog  fa-lg"style="color:#82ccdd"></i>
										
				
									</a>
									<br>
								</li>
								<!-- logout icon -->
								<li class="nav-item">
									<a class="nav-link" href="includes/logout.php">
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