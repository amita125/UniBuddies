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
										
										$select_posts = mysqli_query($connection,"SELECT * FROM student_posts WHERE post_id='$edit_id'");
										$row_posts = mysqli_fetch_array($select_posts);
											
											$post_body = $row_posts['post_content'];
		
												?>


										<form action="" method="POST">
												<textarea name="post_content"><?php echo $post_body;?></textarea>
												<input type="submit" name="update" value="Update">
											</form>

										<?php } ?>
										<?php

											if(isset($_POST['update'])){
												
													$content=$_POST['post_content'];
															
													$update = mysqli_query($connection,"UPDATE student_posts SET post_content='$content' WHERE post_id='$edit_id'")or die( mysqli_error($connection)); 
													
													if($update){
													
													echo "<script>alert('Post  has been updated!')</script>";
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
