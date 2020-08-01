<?php  
if (isset($_SESSION['student_name'])){

			$student_name=$_SESSION['student_name'];
}
if(isset($_POST['update_details'])) {

	$gender = $_POST['gender'];
	$birthday = $_POST['birthday'];
	$level = $_POST['level'];
	$course = $_POST['course'];
	
	$query = mysqli_query($connection, "UPDATE students SET level='$level', course='$course', gender='$gender' , birthday='$birthday' WHERE student_name='$studentLogIn'");
	$message = "Details updated!<br><br>";

}else 
	$message = "";





if(isset($_POST['update_password'])) {

	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password_1']);
	$new_password_2 = strip_tags($_POST['new_password_2']);

	$password_query = mysqli_query($connection, "SELECT password FROM students WHERE student_name='$studentLogIn'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];

	if(md5($old_password) == $db_password) {

		if($new_password_1 == $new_password_2) {


			if(strlen($new_password_1) <= 4) {
				$password_message = "Sorry, your password must be greater than 4 characters<br><br>";
			}	
			else {
				$new_password_md5 = md5($new_password_1);
				$password_query = mysqli_query($connection, "UPDATE students SET password='$new_password_md5' WHERE student_name='$studentLogIn'");
				$password_message = "Password has been changed!<br><br>";
			}


		}
		else {
			$password_message = "Your two new passwords need to match!<br><br>";
		}

	}
	else {
			$password_message = "The old password is incorrect! <br><br>";
	}

}
else {
	$password_message = "";
}


if(isset($_POST['close_account'])) {
	header("Location: close_account.php");
}


?>