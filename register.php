<?php  
require 'connection/connection.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<html>
<head>
	<title>Welcome to UniBuddies!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<link rel="stylesheet" href="assets/css/style.css">
	
	<link rel="stylesheet" href="assets/css/responsive.css">
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php  

	if(isset($_POST['register_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$("#login").hide();
			$("#register").show();
			$("#forgotten").hide();
		});

		</script>

		';
	}
	if(isset($_POST['forgot_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$("#login").hide();
			$("#register").hide();
			$("#forgotten").show();
		});

		</script>

		';
	}

	?>
<div class="theme-layout">
	<div class="container-fluid pdng0">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1><a href="admin/admin_register.php">UniBuddies!</a></h1>
				Login or sign up below!<a href="tour.php" > Take a tour !!</a>
				
			</div>
			<br>
			<div id="first">

				<form action="register.php" method="POST">
					<input type="email" name="login_email" placeholder="Email Address" value="<?php 
					if(isset($_SESSION['login_email'])) {
						echo $_SESSION['login_email'];
					} 
					?>" required>
					<br>
					<input type="password" name="login_password" placeholder="Password">
					<br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "Email or password was incorrect<br>"; ?>
					<a href="forgotPassword.php">Forgot Your Password Click here!</a>
					<br>
					
					<input type="submit" name="login_button" value="Login">
					<br>
					<a href="#" id="signup" class="signup">Need and account? Register here!</a>

				</form>

			</div>

			<div id="second">

				<form action="register.php" method="POST">
					<input type="text" name="firstName" placeholder="First Name" value="<?php 
					if(isset($_SESSION['firstName'])) {
						echo $_SESSION['firstName'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>
					
					


					<input type="text" name="lastName" placeholder="Last Name" value="<?php 
					if(isset($_SESSION['lastName'])) {
						echo $_SESSION['lastName'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>

					<input type="email" name="email" placeholder="Email" value="<?php 
					if(isset($_SESSION['email'])) {
						echo $_SESSION['email'];
					} 
					?>" required>
					<br>

					<input type="email" name="email2" placeholder="Confirm Email" value="<?php 
					if(isset($_SESSION['email2'])) {
						echo $_SESSION['email2'];
					} 
					?>" required>
					<br>

					<input type="email" name="email3" placeholder="University Email" value="<?php 
					if(isset($_SESSION['email3'])) {
						echo $_SESSION['email3'];
					} 
					?>" required>
					<br>

					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>


					<input type="password" name="password" placeholder="Password" required>
					<br>
					<input type="password" name="password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>
					
					
					<input type="text" name="course" placeholder="Course name " value="<?php 
					if(isset($_SESSION['course'])) {
						echo $_SESSION['course'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your course name must be between 1 to 25 characters<br>", $error_array)) echo "Your course name  must be  between 2 and 25 characters<br>"; ?>
					
					
					<label >Gender </label>
					<input type="radio" name="gender" value="female" checked>Female									
					<input type="radio" name="gender" value="male">Male
					
					<br>
					<label>Birthday</label>
					<input type="date" name="birthday" required >
					<br>
					
					<label> Year of study </label>
														<input type="radio" name="level" value="4" checked>	4														
															<input type="radio" name="level" value="5">5
															<input type="radio" name="level" value="6">6
															<input type="radio" name="level" value="7">7
															<br>

					
					
					<input type="checkbox" required> <a href="terms.php">Terms and Condition</a><br>
					
					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>
			
		
</div>
	</div>
	
	</div>
	</div>
	</div>
	</div>


</body>
</html>