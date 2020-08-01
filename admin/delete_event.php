<?php 
	include("includes/config.php");
	
	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from student_events where event_id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 
		
		
		
		echo "<script>alert('event has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_events','_self')</script>"; 
		
		
	}


?> 