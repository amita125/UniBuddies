<table class="table table-hover">
  <thead>
    <tr>
		<th scope="col">S.No</th>
		<th scope="col">Replied By</th>
      <th scope="col">Replied body</th>
      <th scope="col">Date and time</th>
      <th scope="col">Replied To </th>
	  <th scope="col">Forum id </th>
	  <th scope="col">Delete</th>
	  
    </tr>
  </thead>
		<?php 
	$view_replies = "SELECT * FROM forum_replies ORDER by 1 DESC "; 
	$run_replies = mysqli_query($con,$view_replies); 
	$i=0; 
		while($row_replies = mysqli_fetch_array($run_replies)){
			
			$f_id = $row_replies['id']; 
			$replied_by = $row_replies['student_from'];
			$replied_to = $row_replies['student_to'];
			$forum_body = $row_replies['forum_replies'];
			$forum_date = $row_replies['date_added'];
			$forum_id = $row_replies['forum_id'];
			$i++;
	
		?>
  <tbody>
    <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $replied_by; ?></td>
			<td><?php echo $forum_body; ?></td>
			<td><?php echo $forum_date; ?></td>
			<td><?php echo $replied_to; ?></td>
			<td><?php echo $forum_id; ?></td>
			<td><a href="index.php?view_forum_replies&delete=<?php echo $f_id;?>">Delete</a></td>
			
</tr>
    
 </tbody>
		<?php } ?>
</table>
<?php 

	if(isset($_GET['delete'])){
		
		$get_id = $_GET['delete']; 
		
		$delete = "delete from forum_replies where id='$get_id'"; 
		$run_delete = mysqli_query($con,$delete); 

		
		echo "<script>alert('forum replies has been deleted!')</script>"; 
		
		echo "<script>window.open('index.php?view_forum_replies','_self')</script>"; 
	}
?> 
