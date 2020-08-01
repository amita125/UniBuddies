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
		
		$select_forum = mysqli_query($connection,"SELECT * FROM student_forum WHERE forum_id='$edit_id'");
		$row_forum = mysqli_fetch_array($select_forum);
			
			$forum_body = $row_forum['forum_content'];
		
		
?>


<form action="" method="POST">
		<textarea name="forum_content"><?php echo $forum_body;?></textarea>
		<input type="submit" name="update" value="Update">
	</form>

<?php } ?>
<?php

if(isset($_POST['update'])){
	
		$content=$_POST['forum_content'];
				
		$update = mysqli_query($connection,"UPDATE student_forum SET forum_content='$content' WHERE forum_id='$edit_id'")or die( mysqli_error($connection)); 
		
		if($update){
		
		echo "<script>alert('Forum post has been updated!')</script>";
		header('location:forum.php');
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
