<?php  

include("includes/config.php"); 

if(isset($_POST['admin_login'])){
		
		$email = mysqli_real_escape_string($con,$_POST['log_email']);
		$pass = mysqli_real_escape_string($con,$_POST['log_password']);
		
		$get_admin = "SELECT * FROM admin WHERE email='$email' AND password='$pass'";
		
		$run_admin = mysqli_query($con,$get_admin); 
		
		$check_admin = mysqli_num_rows($run_admin); 
		
		if($check_admin==0){
			echo "<script>alert('Email or password is not correct, plz try again')</script>";
		}
		else {
		$row = mysqli_fetch_array($run_admin);
		$username = $row['username'];	
		$_SESSION['username']=$username;
		header("Location: index.php");
		exit;
		}
	
	}

?>


<html>
<head>
	<title>Welcome to UniBuddies!</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/register_style.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	
	<link rel="stylesheet" href="../assets/css/responsive.css">
	
	
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
							<h1>UniBuddies! Admin </h1>
							Login below!
							<a href="../register.php">Go back </a>
						</div>
						<br>
						<form action="admin_register.php" method="POST">
							<input type="email" name="log_email" placeholder="Email Address" value="" required>
							<br>
							<input type="password" name="log_password" placeholder="Password">
							<br>
							
							<input type="submit" name="admin_login" value="Admin Login">
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