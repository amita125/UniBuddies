<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

	<style type="text/css">
	* {
		font-family: Arial, Helvetica, Sans-serif;
	}
	body {
		background-color: #fff;
	}

	form {
		position: absolute;
		top: 0;
	}

	</style>

	<?php  
	require 'connection/connection.php';
	include("includes/classes/User.php");
	include("includes/classes/Post.php");
	include("includes/classes/Notification.php");

	if (isset($_SESSION['student_name'])) {
		$studentLogIn = $_SESSION['student_name'];
		$student_details_query = mysqli_query($connection, "SELECT * FROM students WHERE student_name='$studentLogIn'");
		$student = mysqli_fetch_array($student_details_query);
	}
	else {
		header("Location: register.php");
	}

	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$get_likes = mysqli_query($connection, "SELECT student_liked, created_by FROM student_posts WHERE post_id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['student_liked']; 
	$student_liked = $row['created_by'];

	$student_details_query = mysqli_query($connection, "SELECT * FROM students WHERE student_name='$student_liked'");
	$row = mysqli_fetch_array($student_details_query);
	$total_student_likes = $row['num_likes'];

	//Like button
	if(isset($_POST['like_button'])) {
		$total_likes++;
		$query = mysqli_query($connection, "UPDATE student_posts SET student_liked='$total_likes' WHERE post_id='$post_id'");
		$total_student_likes++;
		$student_likes = mysqli_query($connection, "UPDATE students SET num_likes='$total_student_likes' WHERE student_name='$student_liked'");
		$insert_student = mysqli_query($connection, "INSERT INTO liked_post VALUES('', '$studentLogIn', '$post_id')");

		//Insert Notification
		if($student_liked != $studentLogIn) {
			$notification = new Notification($connection, $studentLogIn);
			$notification->insertNotification($post_id, $student_liked, "like");
		}
	}
	//Unlike button
	if(isset($_POST['unlike_button'])) {
		$total_likes--;
		$query = mysqli_query($connection, "UPDATE student_posts SET student_liked='$total_likes' WHERE post_id='$post_id'");
		$total_student_likes--;
		$student_likes = mysqli_query($connection, "UPDATE students SET num_likes='$total_student_likes' WHERE student_name='$student_liked'");
		$insert_student = mysqli_query($connection, "DELETE FROM liked_post WHERE student_name='$studentLogIn' AND post_id='$post_id'");
	}

	//Check for previous likes
	$check_query = mysqli_query($connection, "SELECT * FROM liked_post WHERE student_name='$studentLogIn' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);

	if($num_rows > 0) {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_like" name="unlike_button" value="Unlike">
				<div class="like_value">
					'. $total_likes .' Likes
				</div>
			</form>
		';
	}
	else {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_like" name="like_button" value="Like">
				<div class="like_value">
					'. $total_likes .' Likes
				</div>
			</form>
		';
	}


	?>




</body>
</html>