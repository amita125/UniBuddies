<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Posted By</th>
      <th scope="col">Post body</th>
      <th scope="col">Date and time</th>
      <th scope="col">Posted To </th>
	  <th scope="col">Delete</th>
		
    </tr>
  </thead>
		<?php 
		
		$select_posts = "SELECT * FROM  student_posts  ORDER by 1 DESC";
		$run_posts = mysqli_query($con,$select_posts);
		
		$i=0; 
		while($row_posts = mysqli_fetch_array($run_posts)){
			
			$post_id = $row_posts['post_id']; 
			$user_by = $row_posts['created_by'];
			$user_to = $row_posts['student_to'];
			$post_body = $row_posts['post_content'];
			$post_date = $row_posts['date_added'];
			$i++;
		?>
		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $post_body; ?></td>
			<td><?php echo $post_date; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><a href="delete_post.php?delete=<?php echo $post_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
  <?php } ?>
</table>

