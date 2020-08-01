<table class="table table-hover">
  <thead>
    <tr>
			<th scope="col">S.N</th>
			<th scope="col">First name </th>
			<th scope="col">Last Name</th>
			<th scope="col">email</th>
			<th scope="col">signup_date</th>
			<th scope="col">uni-email</th>
			<th scope="col">user image </th>
			<th scope="col">Delete</th>
			<th scope="col">Edit</th>
		</tr>
		</thead>
		<?php 
		
		$select_students = "select * from students ORDER by 1 DESC";
		$run_students = mysqli_query($con,$select_students);
		
		$i=0; 
		while($student_row = mysqli_fetch_array($run_students)){
			
			$student_id = $student_row['id'];
			$student_fname = $student_row['first_name'];
			$student_lname = $student_row['last_name'];
			$student_email = $student_row['email'];
			$student_date = $student_row['signup_date'];
			$student_email1=$student_row['uni_email'];
			$student_image = $student_row['profile_pic'];
			
			$i++;
		?>
		<tbody>
    <tr>
		
			<td><?php echo $i; ?></td>
			<td><?php echo $student_fname;?></td>
			<td><?php echo $student_lname; ?></td>
			<td><?php echo $student_email; ?></td>
			<td><?php echo $student_date; ?></td>
			<td><?php echo $student_email1; ?></td>
			<td><img src = "../<?php echo $student_image;?>"width='50' height='50'/></td>
			
			<td><a href="delete_user.php?delete=<?php echo $student_id;?>">Delete</a></td>
			<td><a href="index.php?view_users&edit=<?php echo $student_id;?>">Edit</a></td>
</tr>
    
 </tbody>
  <?php } ?>
</table>

<?php 
		if(isset($_GET['edit'])){
		
		$edit_id = $_GET['edit']; 
		
		$select_students = "select * from students where id='$edit_id'";
		$run_student = mysqli_query($con,$select_students);
		$student_row = mysqli_fetch_array($run_student);
			
			$student_id = $student_row['id'];
			$studentname = $student_row['student_name'];
			$student_fname = $student_row['first_name'];
			$student_lname = $student_row['last_name'];
			$student_gender = $student_row['gender'];
			$student_email = $student_row['email'];
			$student_email1 = $student_row['uni_email'];
			$student_pass = $student_row['password'];
			$student_date = $student_row['birthday'];
			$student_course = $student_row['course'];
			$student_level = $student_row['level'];
		
?>
<form action="" method="POST">
					<input type="text" name="reg_fname" placeholder="<?php echo $student_fname;?>" required>
					<br>
					
					<input type="text" name="reg_lname" placeholder="<?php echo $student_lname;?>" required>
					<br>
					
					<input type="email" name="reg_email" placeholder="<?php echo $student_email;?>"  required>
					<br>

					

					<input type="email" name="reg_email3" placeholder="<?php echo $student_email1;?>"  required>
					<br>



					<input type="password" name="reg_password" placeholder="Password" required>
					<br>
					
					
					
					<input type="text" name="reg_course" placeholder="<?php echo $student_course;?>"  required>
					<br>
					
					<label >Gender </label>
					<input type="radio" name="gender" value="female" checked>Female									
					<input type="radio" name="gender" value="male">Male
					
					<br>
					<label>Birthday</label>
					<input type="date" name="birthday" required >
					<br>
					
					<label> Year of study </label>
														<input type="radio" name="level" value="4" checked>	4														
															<input type="radio" name="level" value="5">5
															<input type="radio" name="level" value="6">6
															<input type="radio" name="level" value="7">7
															<br>

					
					

					
					<input type="submit" name="update" value="Update"/>
					<br>

					
				</form>
				<?php } ?>
<?php 
	if(isset($_POST['update'])){
	
		$u_fname = $_POST['reg_fname']; 
		$u_lname = $_POST['reg_lname'];
		$u_pass = $_POST['reg_password'];
		$u_email = $_POST['reg_email'];
		$u_email1 = $_POST['reg_email3'];
		$u_course = $_POST['reg_course'];
		$u_level = $_POST['level'];
		$u_date=$_POST['birthday'];
		$u_gender=$_POST['gender'];
		
		$update = "UPDATE students SET first_name = '$u_fname ',last_name='$u_lname ',	password='$u_pass ',email='$u_email ',uni_email='$u_email1 ',course='$u_course ',level='$u_level ',	birthday='$u_date',	gender='$u_gender',WHERE id='$edit_id'";
		
		$run = mysqli_query($con,$update); 
		
		if($run){
		
		echo "<script>alert('Student has been updated!')</script>";
		echo "<script>window.open('index.php?view_users','_self')</script>";
		}
	
	}
	?>

