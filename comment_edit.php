<?php

include("includes/header.php");


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
		
		$select_comments = mysqli_query($connection,"SELECT * FROM student_comments WHERE comment_id='$edit_id'");
		$row_comments = mysqli_fetch_array($select_comments);
			
			$c_id = $row_comments['comment_id']; 
			$user_by = $row_comments['student_from'];
			$user_to = $row_comments['student_to'];
			$post_body = $row_comments['comment_content'];
			$post_date = $row_comments['date_added'];
			$post_id = $row_comments['post_id'];
		
		
?>


<form action="" method="POST">
		<textarea name="comment_content"><?php echo $post_body;?></textarea>
		<input type="submit" name="update" value="Update">
	</form>

<?php } ?>
<?php

if(isset($_POST['update'])){
	
		$content=$_POST['comment_content'];
				
		$update = mysqli_query($connection,"UPDATE student_comments SET comment_content='$content' WHERE comment_id='$edit_id'")or die( mysqli_error($connection)); 
		
		if($update){
		
		echo "<script>alert('Comment  has been updated!')</script>";
		header('location:index.php');
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
