<?php 
	include("includes/config.php");
	
	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from group_post where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 
		
		
		
		echo "<script>alert('group post has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_group_post','_self')</script>"; 
		
		
	}


?> 