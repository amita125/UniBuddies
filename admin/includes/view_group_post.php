<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Posted By</th>
      <th scope="col">Group post body</th>
      <th scope="col">Date and time</th>
      <th scope="col">Posted To </th>
      <th scope="col">Group Id </th>
	  <th scope="col">Delete</th>
		
    </tr>
  </thead>
		<?php 
		
		$select_posts = "SELECT * FROM  group_post  ORDER by 1 DESC";
		$run_posts = mysqli_query($con,$select_posts);
		
		$i=0; 
		while($row_posts = mysqli_fetch_array($run_posts)){
			
			$g_id = $row_posts['id']; 
			$user_by = $row_posts['student_from'];
			$user_to = $row_posts['student_to'];
			$group_body = $row_posts['group_content'];
			$group_date = $row_posts['date_added'];
			$group_id = $row_posts['group_id'];
			$i++;
		?>
		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $group_body; ?></td>
			<td><?php echo $group_date; ?></td>
			<td><?php echo $user_to; ?></td>
			<td><?php echo $group_id; ?></td>
			<td><a href="index.php?view_group_post&delete=<?php echo $g_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
  <?php } ?>
</table>

<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from group_post where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('group post has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_group_post','_self')</script>"; 
	}
?> 