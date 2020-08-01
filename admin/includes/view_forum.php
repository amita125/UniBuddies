<table class="table table-hover">
  <thead>
    <tr>
			<th>S.N</th>
			<th>Added By  </th>
			<th>Date</th>
			<th>Forum content </th>
			<th>Delete</th>
		</tr>
		 </thead>
		<?php 
		
		$select_students = "select * from student_forum ORDER by 1 DESC";
		$run_forum = mysqli_query($con,$select_students);
		
		$i=0; 
		while($row_forum = mysqli_fetch_array($run_forum)){
			
			$forum_id = $row_forum['forum_id'];
			$forum_owner = $row_forum['created_by'];
			$forum_date = $row_forum['date_added'];
			$forum_body=$row_forum['forum_content'];
			
			$i++;
		?>
	<tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $forum_owner; ?></td>
			<td><?php echo $forum_date; ?></td>
			<td><?php echo $forum_body; ?></td>
			<td><a href="index.php?view_forum&delete=<?php echo $forum_id;?>">Delete</a></td>
			
		</tr>
</tbody>
  <?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from student_forum where forum_id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('forum has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_forum','_self')</script>"; 
	}
?> 