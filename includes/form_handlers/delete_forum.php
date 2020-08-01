<?php 
require '../../connection/connection.php';
	
	if(isset($_GET['delete'])){
		$forum_id = $_GET['delete'];
			$query = mysqli_query($connection, "DELETE FROM student_forum  WHERE forum_id='$forum_id'");
			header('Location:../../forum.php');
			exit;
	}

	if(isset($_GET['report'])){
		
		$report_id = $_GET['report']; 
		$select_forum = mysqli_query($connection,"SELECT * FROM student_forum  WHERE forum_id='$report_id'");
		$row_forum = mysqli_fetch_array($select_forum);
			$forum_id = $row_forum['forum_id']; 
			$forum_by = $row_forum['created_by'];
			$forum_body = $row_forum['forum_content'];
			$forum_date = $row_forum['date_added'];
			
		$student_report = mysqli_query($connection,"INSERT INTO forum_report VALUES('','$forum_id','$forum_body','$forum_by','$forum_date')");
		header('Location:../../forum.php');
			exit;
	}

?>