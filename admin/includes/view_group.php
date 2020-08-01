<table class="table table-hover">
  <thead>
    <tr>
			<th>S.N</th>
			<th>Group name  </th>
			<th>Owner</th>
			<th>Date</th>
			<th>Group status </th>
			<th>Delete</th>
		</tr>
		 </thead>
		<?php 
		
		$select_students = "select * from group_entry ORDER by 1 DESC";
		$run_students = mysqli_query($con,$select_students);
		
		$i=0; 
		while($row_students = mysqli_fetch_array($run_students)){
			
			$group_id = $row_students['group_id'];
			$group_name = $row_students['group_name'];
			$group_owner = $row_students['created_by'];
			$group_date = $row_students['reg_date'];
			$group_status=$row_students['group_status'];
			
			$i++;
		?>
		
		
  <tbody>
    <tr>
		
			<td><?php echo $i; ?></td>
			<td><?php echo $group_name;?></td>
			<td><?php echo $group_owner; ?></td>
			<td><?php echo $group_date; ?></td>
			<td><?php echo $group_status; ?></td>
			<td><a href="delete_group.php?delete=<?php echo $group_id;?>">Delete</a></td>
			</tr>
</tbody>
  <?php } ?>
</table>