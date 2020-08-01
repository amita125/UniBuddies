	<?php  
	require 'connection/connection.php';
	include("includes/classes/Student.php");
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

	?>

<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

	<style type="text/css">
	@font-face {
    font-family: 'Bellota-LightItalic';
    src: url('../fonts/Bellota-LightItalic.otf');
}
	* {
		font-size: 16px;
		font-family: 'Bellota-LightItalic', sans-serif;
	}
	button.btn.btn-outline-warning {
    height: 20px;
    width: 30px;
    font-size: 10px;
    line-height: 0;
    float: right;
    padding-left: 2px;
	margin-right: 4px;
}
button.btn.btn-outline-danger {
    height: 20px;
    width: 35px;
    line-height: 0;
    font-size: 10px;
    padding-left: 2px;
    float: right;
}

	</style>


	<script>
		function toggle() {
			var element = document.getElementById("comment_section");

			if(element.style.display == "block") 
				element.style.display = "none";
			else 
				element.style.display = "block";
		}
	</script>

	<?php  
	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$student_query = mysqli_query($connection, "SELECT created_by, student_to FROM student_posts WHERE post_id='$post_id'");
	$row = mysqli_fetch_array($student_query);

	$commented_to = $row['created_by'];
	$student_to = $row['student_to'];

	if(isset($_POST['postComment' . $post_id])) {
		$comment_content = $_POST['comment_content'];
		$comment_content = mysqli_escape_string($connection, $comment_content);
		$date_time_now = date("Y-m-d H:i:s");
		$insert_post = mysqli_query($connection, "INSERT INTO student_comments VALUES ('', '$comment_content', '$studentLogIn', '$commented_to', '$date_time_now', '$post_id')");

		if($commented_to != $studentLogIn) {
			$notification = new Notification($connection, $studentLogIn);
			$notification->insertNotification($post_id, $commented_to, "comment");
		}
		
		if($student_to != 'none' && $student_to != $studentLogIn) {
			$notification = new Notification($connection, $studentLogIn);
			$notification->insertNotification($post_id, $student_to, "profile_comment");
		}


		$get_commenters = mysqli_query($connection, "SELECT * FROM student_comments WHERE post_id='$post_id'");
		$notified_students = array();
		while($row = mysqli_fetch_array($get_commenters)) {

			if($row['student_from'] != $commented_to && $row['student_from'] != $student_to 
				&& $row['student_from'] != $studentLogIn && !in_array($row['student_from'], $notified_students)) {

				$notification = new Notification($connection, $studentLogIn);
				$notification->insertNotification($post_id, $row['student_from'], "comment_non_owner");

				array_push($notified_students, $row['student_from']);
			}

		}


		echo "<p>Comment Posted! </p>";
		
	}
	?>
	<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST">
		<textarea name="comment_content"></textarea>
		<input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
	</form>

	<!-- Load comments -->
	<?php  
	$get_comments = mysqli_query($connection, "SELECT * FROM student_comments WHERE post_id='$post_id' ORDER BY comment_id ASC");
	$count = mysqli_num_rows($get_comments);

	if($count != 0) {

		while($comment = mysqli_fetch_array($get_comments)) {

			$comment_content = $comment['comment_content'];
			$student_to = $comment['student_to'];
			$student_from = $comment['student_from'];
			$date_added = $comment['date_added'];
			$c_id = $comment['comment_id'];
			
			if($studentLogIn == $student_from){
						$delete_button = "<button class='btn btn-outline-danger'>Delete</button>";
						$edit_button = "<button class='btn btn-outline-warning'>Edit</button>";
						$report_button ="";
						
			}else {
						$delete_button = "";
					$edit_button ="";
					$report_button = "<button class='btn btn-outline-danger'>Report</button>";
			}
			

			//Timeframe
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($date_added); //Time of post
			$end_date = new DateTime($date_time_now); //Current time
			$interval = $start_date->diff($end_date); //Difference between dates 
			if($interval->y >= 1) {
				if($interval == 1)
					$time_message = $interval->y . " year ago"; //1 year ago
				else 
					$time_message = $interval->y . " years ago"; //1+ year ago
			}
			else if ($interval->m >= 1) {
				if($interval->d == 0) {
					$days = " ago";
				}
				else if($interval->d == 1) {
					$days = $interval->d . " day ago";
				}
				else {
					$days = $interval->d . " days ago";
				}


				if($interval->m == 1) {
					$time_message = $interval->m . " month". $days;
				}
				else {
					$time_message = $interval->m . " months". $days;
				}

			}
			else if($interval->d >= 1) {
				if($interval->d == 1) {
					$time_message = "Yesterday";
				}
				else {
					$time_message = $interval->d . " days ago";
				}
			}
			else if($interval->h >= 1) {
				if($interval->h == 1) {
					$time_message = $interval->h . " hour ago";
				}
				else {
					$time_message = $interval->h . " hours ago";
				}
			}
			else if($interval->i >= 1) {
				if($interval->i == 1) {
					$time_message = $interval->i . " minute ago";
				}
				else {
					$time_message = $interval->i . " minutes ago";
				}
			}
			else {
				if($interval->s < 30) {
					$time_message = "Just now";
				}
				else {
					$time_message = $interval->s . " seconds ago";
				}
			}

			$student_object = new Student($connection, $student_from);


			?>
			<div class="comment_section">
			<a href="comment_frame.php?delete=<?php echo $c_id;?>" target="_parent"> <?php echo $delete_button;?></a>

			<a href="comment_edit.php?edit=<?php echo $c_id;?>" target="_parent"> <?php echo $edit_button;?></a>
			<a href="comment_frame.php?report=<?php echo $c_id;?>" target="_parent"> <?php echo $report_button;?></a>
				<a href="<?php echo $student_from?>" target="_parent"><img src="<?php echo $student_object->getProfilePic();?>" title="<?php echo $student_from; ?>" style="float:left;" height="30"></a>
				<a href="<?php echo $student_from?>" target="_parent"> <b> <?php echo $student_object->getFirstAndLastName(); ?> </b></a>
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message . "<br>" . $comment_content; ?> 
				
				
				
				
				
				<hr>
			</div>
			<?php

		}
	}
	else {
		echo "<center><br><br>No Comments to Show!</center>";
	}

	?>

<?php   
		if(isset($_GET['delete'])){
		$get_id = $_GET['delete']; 
		$delete = "delete from student_comments where comment_id='$get_id'"; 
		$run_delete = mysqli_query($connection,$delete); 
		header('location:index.php');
		exit;
	}
	
	if(isset($_GET['report'])){
		
		$report_id = $_GET['report']; 
		$select_comment = mysqli_query($connection,"SELECT * FROM student_comments WHERE comment_id='$report_id'");
		$row = mysqli_fetch_array($select_comment);
		$comment_id = $row['comment_id'];
		$comment_body = $row['comment_content'];
		$comment_from = $row['student_from'];
		$comment_to = $row['student_to'];
		$comment_date=$row['date_added'];
		$comment_post=$row['post_id'];

		$student_report = mysqli_query($connection,"INSERT INTO comment_report VALUES('','$comment_id','$comment_body','$comment_from','$comment_to','$comment_date','$comment_post')");
		header('location:index.php');
		exit;
	}
	
	
	
?>





</body>
</html>