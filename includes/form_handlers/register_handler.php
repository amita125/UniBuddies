<?php
//Declaring variables to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$level = ""; //level of study
$course = ""; //course name
$gender = "";//gender 
$dob="";//birthday
$em = ""; //email
$em2 = ""; //email 2
$em3 = ""; //email 3 uni email address 
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date 
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

	//Registration form values

	//First name
	$fname = strip_tags($_POST['firstName']); //Remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['firstName'] = $fname; //Stores first name into session variable

	//Last name
	$lname = strip_tags($_POST['lastName']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['lastName'] = $lname; //Stores last name into session variable


	//course name
	$course = strip_tags($_POST['course']); //Remove html tags
	$course = str_replace(' ', '', $course); //remove spaces
	$course = ucfirst(strtolower($course)); //Uppercase first letter
	$_SESSION['course'] = $course; //Stores last name into session variable

	//email
	$em = strip_tags($_POST['email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$_SESSION['email'] = $em; //Stores email into session variable

	//email 2
	$em2 = strip_tags($_POST['email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2); //remove spaces
	$_SESSION['email2'] = $em2; //Stores email2 into session variable
	
	//email 3
	$em3 = strip_tags($_POST['email3']); //Remove html tags
	$em3 = str_replace(' ', '', $em3); //remove spaces
	$_SESSION['email3'] = $em3; //Stores email3 into session variable

	//Password
	$password = strip_tags($_POST['password']); //Remove html tags
	$password2 = strip_tags($_POST['password2']); //Remove html tags

	$date = date("Y-m-d"); //Current date
	$gender = $_POST['gender'];
	$level = $_POST['level'];
	$dob = $_POST['birthday'];
	if($em == $em2) {
		//Check if email is in valid format 
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists 
			$e_check = mysqli_query($connection, "SELECT email FROM students WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}


	}
	else {
		array_push($error_array, "Emails don't match<br>");
	}
	
	$domain = "my.westminster.ac.uk";
	if (strpos($em3, $domain) !== false && substr($em3, 0, 1) == 'w') {
		//Check if email already exists 
		$e_check1 = mysqli_query($connection, "SELECT uni_email FROM students WHERE uni_email='$em3'");

		//Count the number of rows returned
		$num_rows = mysqli_num_rows($e_check1);

		if($num_rows > 0) {
			array_push($error_array, "Email already in use<br>");
		}
	}
	else{
		array_push($error_array, "Invalid email format<br>");
		
	}
	

	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}
	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
	}

	

	if(strlen($course) > 25 || strlen($course) < 2) {
		array_push($error_array,  "Your course name must be between 2 and 25 characters<br>");
	}


	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}


	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database

		//Generate student_name by concatenating first name and last name
		$student_name = strtolower($fname . "_" . $lname);
		$check_student_name_query = mysqli_query($connection, "SELECT student_name FROM students WHERE student_name='$student_name'");


		$i = 0; 
		//if student_name exists add number to student_name
		while(mysqli_num_rows($check_student_name_query) != 0) {
			$i++; //Add 1 to i
			$student_name = $student_name . "_" . $i;
			$check_student_name_query = mysqli_query($connection, "SELECT student_name FROM students WHERE student_name='$student_name'");
		}

		//Profile picture assignment
		
			$profile_pic = "assets/images/profile-pics/pro.jpg";
		
		//cover picture assignment 
		$rand = rand(1, 2); //Random number between 1 and 2
		if($rand == 1)
			$cover_pic = "assets/images/cover-pics/astronomy.jpg";
		else if($rand == 2)
			$cover_pic = "assets/images/cover-pics/foggy.jpg";
		
		$query = mysqli_query($connection, "INSERT INTO students VALUES ('', '$fname', '$lname', '$student_name', '$em', '$password', '$date','$em3', '$profile_pic', '$cover_pic','0', '0', 'no', ',','$course','$level','$gender','$dob')");

		array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");

		//Clear session variables 
		$_SESSION['firstName'] = "";
		$_SESSION['lastName'] = "";
		$_SESSION['email'] = "";
		$_SESSION['email2'] = "";
		$_SESSION['email3'] = "";
		$_SESSION['level'] = "";
		$_SESSION['course'] = "";
	}

}

if(isset($_POST['forgot_button'])){
	//Registration form values

	//First name
	$fname = strip_tags($_POST['firstName']); //Remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['firstName'] = $fname; //Stores first name into session variable

	//Last name
	$lname = strip_tags($_POST['lastName']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['lastName'] = $lname; //Stores last name into session variable


	//email
	$em = strip_tags($_POST['email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$_SESSION['email'] = $em; //Stores email into session variable

	//email 3
	$em3 = strip_tags($_POST['email3']); //Remove html tags
	$em3 = str_replace(' ', '', $em3); //remove spaces
	$_SESSION['email3'] = $em3; //Stores email3 into session variable

	//Password
	$password = strip_tags($_POST['password']); //Remove html tags
	$password2 = strip_tags($_POST['password2']); //Remove html tags

	
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);
		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}


	$domain = "my.westminster.ac.uk";
	if (strpos($em3, $domain) !== false && substr($em3, 0, 1) == 'w') {
	}
	else{
		array_push($error_array, "Invalid university email format<br>");
	}
	

	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}
	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
	}

	

	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}


	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database

		$password_query = mysqli_query($connection, "SELECT * FROM students WHERE first_name ='$fname'AND last_name='$lname' AND email='$em' AND uni_email='$em3'  ");
		$row = mysqli_fetch_array($password_query);
		$student_name = $row['student_name'];
	
		$password_query1 = mysqli_query($connection, "UPDATE students SET password='$password' WHERE student_name='$student_name'" );
		

		array_push($error_array, "<span style='color: #14C800;'>Your password updated ! Go ahead and login!</span><br>");

		//Clear session variables 
		$_SESSION['firstName'] = "";
		$_SESSION['lastName'] = "";
		$_SESSION['email'] = "";
		$_SESSION['email3'] = "";
	
	}
}
?>