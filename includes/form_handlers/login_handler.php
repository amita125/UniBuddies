<?php  

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL); //sanitize email

	$_SESSION['login_email'] = $email; //Store email into session variable 
	$password = md5($_POST['login_password']); //Get password

	$check_database_query = mysqli_query($connection, "SELECT * FROM students WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$student_name = $row['student_name'];

		$user_closed_query = mysqli_query($connection, "SELECT * FROM students WHERE email='$email' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($connection, "UPDATE students SET user_closed='no' WHERE email='$email'");
		}

		$_SESSION['student_name'] = $student_name;
		header("Location: index.php");
		exit();
	}
	else {
		array_push($error_array, "Email or password was incorrect<br>");
	}


}

?>