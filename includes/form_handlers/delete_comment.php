<?php 
require '../../connection/connection.php';
	
	if(isset($_GET['post_id']))
		$post_id = $_GET['post_id'];

	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			$query = mysqli_query($connection, "DELETE FROM student_comments  WHERE comment_id='$post_id'");
	}

?>