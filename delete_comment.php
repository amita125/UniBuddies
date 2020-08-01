<?php 

require'connection/connection.php';

if(isset($_GET['delete'])){
	$delete_id = $_GET['delete'];
	$delete = "delete from student_comments where comment_id='$delete_id'"; 
		$run_delete = mysqli_query($connection,$delete); 
		echo "<script>alert('Comment has been deleted!')</script>"; 
}


?>