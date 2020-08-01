	<?php
		include("includes/header.php");//header file is included 

		//call the cancel button pressed 
		if(isset($_POST['cancel'])) {
			header("Location: settings.php");//the user is directed to the setting page 
		}

		//call the close account 
		if(isset($_POST['close_account'])) {
			//as soon as the close button is pressed the user table is updated which displays yes for the closed row . 
			$close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");  
			//a session is destroyed for the user 
			session_destroy();
			//user redirected to the register page 
			header("Location: register.php");
		}
	?>
		<div class="space space-bg">
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
									<div class="center-area">
										<div class="posts_area">
											<h4>Close Account</h4>
											Are you sure you want to close your account?<br>
											Sorry to see you leave . Hope to see you soon <br>
											Dont worry You can re-open your account at any time by simply logging in.<br><br>
											
											<!-- Form to get the user input -->
											<form action="close_account.php" method="POST">
												<input type="submit" name="close_account" id="close_account" value="Yes! Close it!" class="danger settings_submit">
												<input type="submit" name="cancel" id="update_details" value="No way!" class="info settings_submit">
											</form>
											<!-- form end -->
										</div><!-- div close for the post area -->
									</div>
								</div>
							</div><!-- centerl meta -->

							<div class="col-lg-3">
								<aside class="sidebar static">
                                <!-- profile info start -->
                                <div class="info">
                                    <h4 class="info-title">Profile Info</h4>
									<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>
                                    <div class="profile_info">
                                        <p>
                                            <?php echo " Name :" .$user['first_name'] . " " . $user['last_name']; ?>
                                        </p>
										<p>
                                            <?php echo  "Gender : " . $user['gender']; ?>
                                        </p>
										<p>
                                            <?php echo "Birthday : " . $user['birthday']; ?>
                                        </p>
                                        <p>
                                            <?php echo "Level of Study : ".$user['level'] ; ?>
                                        </p>
                                        <p>
                                            <?php echo" Course enrolled :".$user['course']; ?>
                                        </p>
                                        <p>
                                            <?php echo "Posts: " . $user['num_posts']; ?>
                                        </p>
                                        <p>
                                            <?php echo "Likes: " . $user['num_likes']; ?>
                                        </p>
                                        
                                    </div>
                                </div>
                                <!-- profile info end  -->
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