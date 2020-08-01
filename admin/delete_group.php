<?php 
	include("includes/config.php");
	
	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from group_entry where group_id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 
		
		
		
		echo "<script>alert('Group has been deleted !')</script>"; 
		
		echo "<script>window.open('index.php?view_group','_self')</script>"; 
		
		
	}


?> 