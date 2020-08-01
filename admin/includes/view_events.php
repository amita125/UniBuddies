
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Event Name</th>
      <th scope="col">Date</th>
      <th scope="col">Time</th>
	  <th scope="col">Description</th>
	  <th scope="col">By</th>
	  <th scope="col">Status</th>
	  <th scope="col">Delete</th>
    </tr>
  </thead>
  <?php 
		
		$select_events = "select * from student_events ORDER by 1 DESC";
		$run_events = mysqli_query($con,$select_events);
		
		$i=0; 
		while($row_users = mysqli_fetch_array($run_events)){
			
			$e_id = $row_users['event_id'];
			$e_name = $row_users['event_name'];
			$e_date = $row_users['event_date'];
			$e_time = $row_users['event_time'];
			$e_description = $row_users['event_description'];
			$e_by=$row_users['created_by'];
			$e_status=$row_users['event_status'];
			
			$i++;
		?>
  
  <tbody>
    <tr>
      
<td> <?php echo $i ;?></td>
<td> <?php echo $e_name ;?></td>
<td><?php echo $e_date ;?></td>
<td><?php echo $e_time ;?> </td>
<td><?php echo $e_description ;?> </td>
<td><?php echo $e_by;?> </td>
<td> <?php echo $e_status;?></td>
<td><a href="delete_event.php?delete=<?php echo $e_id;?>">Delete</a></td>
</tr>
    
 </tbody>
  <?php } ?>
</table>
