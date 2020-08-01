<?php 
	include("includes/config.php");
	
	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 


		$delete = "delete from students where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete);
		
		$select_student = "select * from students where id='$get_id'"; 
		$run_user= mysqli_query($con,$select_student); 
		$row_users= mysqli_fetch_array($run_user);
			
		$username = $row_users['student_name'];

		$select_post = mysqli_query($con ,"DELETE  FROM student_posts WHERE created_ ='$username'" );
		$delelete_group = mysqli_query($con ,"DELETE  FROM group_entry WHERE created_by ='$username'" );
		$delete_event = mysqli_query($con ,"DELETE  FROM student_events WHERE created_by ='$username'" );
		$delete_comment = mysqli_query($con ,"DELETE  FROM student_comments WHERE student_from ='$username'" );
		
		echo "<script>alert('User and its related have been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_users','_self')</script>"; 
		
		
	}
	
?> 

 