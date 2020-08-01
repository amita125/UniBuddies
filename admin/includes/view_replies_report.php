<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Forum id </th>
		<th scope="col">Replies id </th>
		<th scope="col">Replied By</th>
      <th scope="col">Replies body</th>
      <th scope="col">Replied To </th>
      <th scope="col">Date and time</th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_forum = "SELECT * FROM forum_replies_report ORDER by 1 DESC "; 
	$run_forums = mysqli_query($con,$view_forum); 
	$i=0; 
		while($row_forums = mysqli_fetch_array($run_forums)){
			$report_id = $row_forums['id'];
			$f_id = $row_forums['replies_id']; 
			$user_by = $row_forums['student_from'];
			$user_to = $row_forums['student_to'];
			$replies_body = $row_forums['forum_content'];
			$replies_date = $row_forums['date_added'];
			$forum_id = $row_forums['forum_id'];
			$i++;
	
		?>
  <tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $forum_id; ?></td>
			<td><?php echo $f_id; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $replies_body; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><?php echo $replies_date; ?></td>
			
			
			<td><a href="index.php?view_replies_report&delete=<?php echo $report_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from forum_replies_report where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('Forum replies has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_replies_report','_self')</script>"; 
	}
?> 

