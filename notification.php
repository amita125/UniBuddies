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

											$notification = new Notification($connection, $studentLogIn)or die( mysqli_error($connection));
											echo $notification->getNotifications($studentLogIn);

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