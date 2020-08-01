	<?php
		include("includes/header.php");

		//post button 
		if(isset($_POST['post'])){
			
			$uploadOk = 1;
			$imageName = $_FILES['fileToUpload']['name'];
			$errorMessage = "";

			if($imageName != "") {
				//target file where we want the post images to be uploaded 
				$targetDir = "assets/images/posts/"; 
				//unique id is assigned to the images 
				$imageName = $targetDir . uniqid() . basename($imageName);
				$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

				if($_FILES['fileToUpload']['size'] > 10000000) {
					$errorMessage = "Sorry your file is too large";
					$uploadOk = 0;
				}
				//all the file type are changed to the lower case for the easy call
				if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
					$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
					$uploadOk = 0;
				}
				//if the upload all is ok then the file is moved to the target folder 
				if($uploadOk) {
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
						//image uploaded okay
					}
					else {
						//image did not upload
						$uploadOk = 0;
					}
				}
			}
			//if the image upload is ok then the the post is sent 
			if($uploadOk) {
				$post = new Post($connection, $studentLogIn);
				$post->submitPost($_POST['post_text'], 'none', $imageName);
			}
			else {
				echo "<div style='text-align:center;' class='alert alert-danger'>
						$errorMessage
					</div>";
			}
			//user directed to the index page 
			header("Location: index.php");
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
												<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
													<textarea name="post_text" id="post_text" placeholder="Got something to say?"rows="2" ></textarea>
													<div class="attachments">
														<ul>
															<li>
																<input type="file" name="fileToUpload" id="fileToUpload">
															</li>
															<li>
																<input type="submit" name="post" id="post_button" value="Post">
															</li>
														</ul>
													</div>
												</form>
											</div>
										</div>
										<hr>
										<br>
										<?php 
											$post = new Post($connection, $studentLogIn);
											$post->loadPosts();
										?>
										<b>Sorry no more post </b>
									</div><!-- add post new box -->
								</div>
							</div><!-- centerl meta -->
							<div class="col-lg-3">
								<aside class="sidebar static">
                                <!-- profile info start -->
	                                <div class="widget">
	                                    <h4 class="widget-title">Profile Info</h4>
										<a href="<?php echo $studentLogIn; ?>">  <img src="<?php echo $student['profile_pic']; ?>"> </a>
	                                    <div class="profile_info">
	                                        <p>
	                                            <?php echo " Name :" .$student['first_name'] . " " . $student['last_name']; ?>
	                                        </p>
											<p>
	                                            <?php echo  "Gender : " . $student['gender']; ?>
	                                        </p>
											<p>
	                                            <?php echo "Birthday : " . $student['birthday']; ?>
	                                        </p>
	                                        <p>
	                                            <?php echo "Level of Study : ".$student['level'] ; ?>
	                                        </p>
	                                        <p>
	                                            <?php echo" Course enrolled :".$student['course']; ?>
	                                        </p>
	                                        <p>
	                                            <?php echo "Posts: " . $student['num_posts']; ?>
	                                        </p>
	                                        <p>
	                                            <?php echo "Likes: " . $student['num_likes']; ?>
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