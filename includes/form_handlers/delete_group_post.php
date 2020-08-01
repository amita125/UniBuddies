<?php 
require '../../connection/connection.php';

	if(isset($_GET['delete'])){
		$post_id = $_GET['delete'];
			$query = mysqli_query($connection, "DELETE FROM group_post  WHERE id='$post_id'");
			header('Location:../../group.php');
			exit;
	}
	
	if(isset($_GET['report'])){
		
		$report_id = $_GET['report']; 
		$select_post = mysqli_query($connection,"SELECT * FROM group_post  WHERE id='$report_id'");
		$row_posts = mysqli_fetch_array($select_post);
			$post_id = $row_posts['id']; 
			$user_by = $row_posts['student_from'];
			$user_to = $row_posts['student_to'];
			$post_body = $row_posts['group_content'];
			$post_date = $row_posts['date_added'];
			$post_group=$row_posts['group_id'];

		$student_report = mysqli_query($connection,"INSERT INTO group_report VALUES('','$post_id','$post_body','$user_by','$user_to','$post_date','$post_group')");
		header('Location:../../group.php');
			exit;
	}
?>

