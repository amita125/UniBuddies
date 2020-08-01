<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Forum id </th>
		<th scope="col">Created By</th>
      <th scope="col">Forum body</th>
      <th scope="col">Date and time</th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_forum = "SELECT * FROM forum_report ORDER by 1 DESC "; 
	$run_forum = mysqli_query($con,$view_forum); 
	$i=0; 
		while($row_forum = mysqli_fetch_array($run_forum)){
			$report_id = $row_forum['id'];
			$forum_id = $row_forum['forum_id'];
			$user_by = $row_forum['created_by'];
			$forum_body = $row_forum['forum_content'];
			$forum_date = $row_forum['date_added'];
			$i++;
		?>
  <tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $forum_id; ?></td>
			<td><?php echo $user_by; ?></td>
			<td><?php echo $forum_body; ?></td>
			<td><?php echo $forum_date; ?></td>
			
			
			<td><a href="index.php?view_forum_report&delete=<?php echo $report_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from forum_report where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('Forum post report has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_forum_report','_self')</script>"; 
	}
?> 

