<?php

include("includes/header.php");
if(isset($_GET['view'])) {
			$view_id = $_GET['view'];
			$student_details_query = mysqli_query($connection, "SELECT * FROM group_entry WHERE group_id='$view_id'");
			$student_array = mysqli_fetch_array($student_details_query);
			$view_name = $student_array['group_name'];
			$view_student_name = $student_array['created_by'];

		}

?>
		<div class="gap1 gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
							<!-- shortcut navigation -->
                			<?php include("shortcut.php");?>
								
							</div><!-- sidebar -->
							<div class="col-lg-6">
								<div class="loadMore">
									<div class="central-meta item">
										<?php 
										
		if(isset($_GET['edit'])){
		
		$edit_id = $_GET['edit']; 
		
		$select_group_posts = mysqli_query($connection,"SELECT * FROM group_post WHERE id='$edit_id'");
		$row_posts = mysqli_fetch_array($select_group_posts);
			
			$post_body = $row_posts['group_content'];
		
		
?>


<form action="" method="POST">
		<textarea name="group_content"><?php echo $post_body;?></textarea>
		<input type="submit" name="update" value="Update">
	</form>

<?php } ?>
<?php

if(isset($_POST['update'])){
	
		$content=$_POST['group_content'];
				
		$update = mysqli_query($connection,"UPDATE group_post SET group_content='$content' WHERE id='$edit_id'")or die( mysqli_error($connection)); 
		
		if($update){
		
		echo "<script>alert('Post  has been updated!')</script>";
		header('location:group.php');
		exit;
		}
	
	}
?>

									</div>
								</div>
							</div><!-- centerl meta -->

							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $student['profile_pic']; ?>" style="height : 200px;width:300px;"> </a>
										<div class="user_details_left_right">
											<a href="<?php echo $userLoggedIn; ?>">
												
												<?php 
													echo $student['first_name'] . " " . $student['last_name'];
												?>
											</a>
											<br>
											<?php echo "Posts: " . $student['num_posts']. "<br>"; 
												echo "Likes: " . $student['num_likes'];
											?>
										</div>
									</div><!--user details sidebar -->
									
								</aside>
							</div><!-- sidebar -->
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</body>
</html>
