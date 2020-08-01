<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Post id </th>
		<th scope="col">Posted By</th>
      <th scope="col">Post body</th>
      <th scope="col">Posted To </th>
	  <th scope="col">Post Image </th>
      <th scope="col">Date and time</th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_post = "SELECT * FROM post_report ORDER by 1 DESC "; 
	$run_posts = mysqli_query($con,$view_post); 
	$i=0; 
		while($row_posts = mysqli_fetch_array($run_posts)){
			$report_id = $row_posts['id'];
			$post_id = $row_posts['post_id'];
			$user_by = $row_posts['post_from'];
			$user_to = $row_posts['post_to'];
			$post_body = $row_posts['post_content'];
			$post_date = $row_posts['date_added'];
			$post_image = $row_posts['post_image'];
			$i++;
		?>
  <tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $post_id; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $post_body; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><?php echo $post_image; ?></td>
			<td><?php echo $post_date; ?></td>
			
			
			<td><a href="index.php?view_post_report&delete=<?php echo $report_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from post_report where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('Report post has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_post_report','_self')</script>"; 
	}
?> 

