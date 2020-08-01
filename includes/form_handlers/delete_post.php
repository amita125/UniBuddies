<?php 
require '../../connection/connection.php';
if (isset($_SESSION['student_name'])) {
		$studentLogIn = $_SESSION['student_name'];
		
	}
	if(isset($_GET['delete'])){
		$post_id = $_GET['delete'];
			$query = mysqli_query($connection, "DELETE FROM student_posts  WHERE post_id='$post_id'");
			header("Location:../../index.php");
			exit;
			
	}
	
	if(isset($_GET['delete1'])){
		$post_id = $_GET['delete1'];
			$query = mysqli_query($connection, "DELETE FROM student_posts  WHERE post_id='$post_id'");
			
			header("Location:../../profile.php?profile_student_name=$studentLogIn");
			exit;
	}
	if(isset($_GET['report'])){
		
		$report_id = $_GET['report']; 
		$select_post = mysqli_query($connection,"SELECT * FROM student_posts  WHERE post_id='$report_id'");
		$row_posts = mysqli_fetch_array($select_post);
			$post_id = $row_posts['post_id']; 
			$user_by = $row_posts['created_by'];
			$user_to = $row_posts['student_to'];
			$post_body = $row_posts['post_content'];
			$post_date = $row_posts['date_added'];
			$post_image=$row_posts['post_image'];

		$student_report = mysqli_query($connection,"INSERT INTO post_report VALUES('','$post_id','$post_body','$user_by','$user_to','$post_date','$post_image')");
		header('Location:../../index.php');
			exit;
	}
?>

