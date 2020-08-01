<?php 
	include("includes/config.php");
	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from student_posts where post_id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 
		echo "<script>alert('Post has been deleted!')</script>"; 
		echo "<script>window.open('index.php?view_posts','_self')</script>"; 
	}
?> 