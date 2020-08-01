<?php  
require 'connection/connection.php';

require 'includes/form_handlers/register_handler.php';

?>


<html>
<head>
	<title>Welcome to UniBuddies!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<link rel="stylesheet" href="assets/css/style.css">
	
	<link rel="stylesheet" href="assets/css/responsive.css">
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
</head>
<body>

<div class="theme-layout">
	<div class="container-fluid pdng0">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="wrapper">
					<div class="login_box">
						<div class="login_header">
							<h1>UniBuddies!</h1>
							Forgot Password or  
							<a href="register.php">Go back to Login </a>
						</div>
						<br>
						<form action="forgotPassword.php" method="POST">
						
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
					

					<input type="email" name="email3" placeholder="University Email" value="<?php 
					if(isset($_SESSION['email3'])) {
						echo $_SESSION['email3'];
					} 
					?>" required>
					<br>

					<input type="password" name="password" placeholder="New Password" required>
					<br>
					<input type="password" name="password2" placeholder="Confirm New Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>
					
					
<?php if(in_array("<span style='color: #14C800;'>Your password updated ! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>Your password updated ! Go ahead and login!</span><br>"; ?>
					
					<input type="submit" name="forgot_button" value="Update Password"><br>
					<a href="register.php" >Sign in here!</a>
					<br>

				</form>
						
							
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>