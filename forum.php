	<?php
		include("includes/header.php");

		if(isset($_POST['post'])){
			$post = new Forum($connection, $studentLogIn);
			$post->submitForum($_POST['post_text'], 'none');
			header("Location: forum.php");
			exit;
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
										<div class="new-postbox">
											<figure>
												<img src="<?php echo $student['profile_pic']; ?>">
											</figure>
											<div class="newpost-input">
												<form class="post_form" action="forum.php" method="POST">
												
													<textarea name="post_text" id="post_text" placeholder="Forum Title"rows="2" ></textarea>
													<div class="attachments">
														<ul>
															<li>
																<input type="submit" name="post" id="post_button" value="Create">
															</li>
														</ul>
													</div>
												</form>
											</div>
										</div>
										<hr>
										<br>
										<?php 
											$post = new Forum($connection, $studentLogIn);
											$post->loadForumPosts();
										?>
									</div><!-- add post new box -->
								</div>
							</div><!-- centerl meta -->
							

							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">Friends</h4>
										<?php
										$student_object = new Student($connection, $studentLogIn);
										 
										foreach($student_object->getFriendsList() as $friend) {
										 
											$friend_object = new Student($connection, $friend);
										 
											echo "<a href='$friend'>
													<img class='profilePicSmall' src='" . $friend_object->getProfilePic() ."'>"
													. $friend_object->getFirstAndLastName() . 
												"</a>
												<br>";
										}
										?>
									</div><!-- friends list sidebar -->
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