<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Post id </th>
		<th scope="col">Comment id </th>
		<th scope="col">Commented By</th>
      <th scope="col">Comment body</th>
      <th scope="col">Commented To </th>
      <th scope="col">Date and time</th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_comment = "SELECT * FROM comment_report ORDER by 1 DESC "; 
	$run_comments = mysqli_query($con,$view_comment); 
	$i=0; 
		while($row_comments = mysqli_fetch_array($run_comments)){
			$report_id = $row_comments['id'];
			$c_id = $row_comments['comment_id']; 
			$user_by = $row_comments['student_from'];
			$user_to = $row_comments['student_to'];
			$post_body = $row_comments['comment_content'];
			$post_date = $row_comments['date_added'];
			$post_id = $row_comments['post_id'];
			$i++;
	
		?>
  <tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $post_id; ?></td>
			<td><?php echo $c_id; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $post_body; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><?php echo $post_date; ?></td>
			
			
			<td><a href="index.php?view_comment_report&delete=<?php echo $report_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from comment_report where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('Report comment has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_comment_report','_self')</script>"; 
	}
?> 

