<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Commented By</th>
      <th scope="col">Post body</th>
      <th scope="col">Date and time</th>
      <th scope="col">Commented To </th>
	  <th scope="col">Post id </th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_comment = "SELECT * FROM student_comments ORDER by 1 DESC "; 
	$run_comments = mysqli_query($con,$view_comment); 
	$i=0; 
		while($row_comments = mysqli_fetch_array($run_comments)){
			
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
			<td><?php echo $user_by; ?></td>
			<td><?php echo $post_body; ?></td>
			<td><?php echo $post_date; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><?php echo $post_id; ?></td>
			<td><a href="delete_comment.php?delete=<?php echo $c_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>

