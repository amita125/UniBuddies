	<?php
		//header file contain the top navigation with the connection , css, classes 
		include("includes/header.php");		
		//message object created using the message class 
		$message_object = new Message($connection, $studentLogIn);
		if(isset($_GET['profile_student_name'])) {
			$student_name = $_GET['profile_student_name'];
			$student_details_query = mysqli_query($connection, "SELECT * FROM students WHERE student_name='$student_name'");
			$student_array = mysqli_fetch_array($student_details_query);
			$num_friends = (substr_count($student_array['friend_array'], ","))-1;
		}

		if(isset($_POST['remove_friend'])) {
			$student = new Student($connection, $studentLogIn);
			$student->unFriend($student_name);
		}
		//remove the friend button 

		if(isset($_POST['add_friend'])) {
			$student = new Student($connection, $studentLogIn);
			$student->sendRequest($student_name);
		}
		//add friend button 

		if(isset($_POST['respond_request'])) {
			header("Location: requests.php");
		}
		//respond to the friend button 
		
		if(isset($_GET['delete'])){	
			$delete_id = $_GET['delete'];
			mysqli_query($connection,"DELETE FROM images WHERE id='$delete_id'");
			header("Location: profile.php?profile_student_name=$studentLogIn");
			exit;
		}
		if(isset($_POST['post_message'])) {
			  if(isset($_POST['message_body'])) {
				$body = mysqli_real_escape_string($connection, $_POST['message_body']);
				$date = date("Y-m-d H:i:s");
				$message_object->sendMessage($student_name, $body, $date);
			
				}

		  $link = '#pills-tab a[href="#pills-message"]';
		  echo "<script> 
		          $(function() {
		              $('" . $link ."').tab('show');
		          });
		        </script>";
		       
		}

		if(isset($_POST['post'])) {
			
			$imgOk = 1;
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
					$imgOk = 0;
				}
				//all the file type are changed to the lower case for the easy call
				if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
					$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
					$imgOk = 0;
				}
				//if the upload all is ok then the file is moved to the target folder 
				if($imgOk) {
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
						//image uploaded okay
					}
					else {
						//image did not upload
						$imgOk = 0;
					}
				}
			}
			//if the image upload is ok then the the post is sent 
			if($imgOk) {
				$post = new Post($connection, $_POST['created_by']);
				$post->submitPost($_POST['post_body'], $_POST['student_to'],$imageName);
			}
			else {
				echo "<div style='text-align:center;' class='alert alert-danger'>
						$errorMessage
					</div>";
			}
			//user directed to the index page 
			header("Location: profile.php?profile_student_name=$student_name");
		
		}
	
	?>

	<!-- main section  -->
	<div class="feature-photo">
	    <!-- cover image -->
	    <figure>
	        <img src="<?php echo $student_array['cover_pic']; ?>">
	    </figure>
	    <!-- end of cover image -->
	    <!-- button to add friend or remove  -->
	    <div class="add-btn">
	        <form action="<?php echo $student_name; ?>" method="POST">

	            <?php 
		 			$profile_student_object = new Student($connection, $student_name); 
		 			if($profile_student_object->accountClosed()) {
		 				header("Location: user_closed.php");
		 			}
		 			//checks if the user is closed or not 

		 			$logged_in_student_object = new Student($connection, $studentLogIn); 

		 			// this button is displayed only when the user goes to other people's profile 

		 			if($studentLogIn != $student_name) {

		 				if($logged_in_student_object->isBuddy($student_name)) {
		 					echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
		 				}
		 				else if ($logged_in_student_object->didReceiveRequest($student_name)) {
		 					echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
		 				}
		 				else if ($logged_in_student_object->didSendRequest($student_name)) {
		 					echo '<input type="submit" name="" class="default" value="Request Sent"><br>';
		 				}
		 				else 
		 					echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';
		 			}
	 			?>
	        </form>
	    </div>
	    <!-- end of button to add or remove friend-->
	    <!-- cover photo form  -->
	    <?php
			if($studentLogIn == $student_name){ 
			//checks whether it is user logged in as we want to show edit button only to the user not to their friends   
		?>
	    <!-- Edit button for cover photo -->
	    <form class="edit-photo" action="coverPic.php" method="post" enctype="multipart/form-data">
	        <input type="file" name="fileToUpload" id="fileToUpload">
	        <input type="submit" value="Upload Image" name="submit">
	    </form>
	    <?php 
			} //close of if tag 
		?>
	    <!-- end of cover photo edit  -->

	    <!-- start of second navigation  -->
	    <div class="container-fluid">
	        <div class="row merged">
	            <!-- div container to wrap profile image s  -->
	            <div class="col-lg-2 col-sm-3">
	                <!-- profile image   -->
	                <div class="user-avatar">
	                    <figure>
	                        <img src="<?php echo $student_array['profile_pic']; ?>">
	                        <!-- Profile pic  -->
	                        <?php
								if($studentLogIn == $student_name){
								//checks whether it is user logged in as we want to show edit button only to the user not to their friends 
							?>
	                        <!-- Edit button for profile photo -->
	                        <form class="edit-photo" action="profilePic.php" method="post" enctype="multipart/form-data">
	                            <input type="file" name="fileToUpload" id="fileToUpload">
	                            <input type="submit" value="Upload Image" name="submit">
	                        </form>

	                        <?php
								}//close of if tag	
							?>
	                    </figure>
	                </div>
	                <!-- end of profile image  -->
	            </div>
	            <!-- end of div container for profile image -->
	            <!-- div container to wrap the inner navigation   -->
	            <div class="col-lg-10 col-sm-9">
	                <div class="timeline-info">
	                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	                        <!-- display user name  -->
	                        <li class="user-name">
	                            <h5>
	                                <?php echo $student_name; ?>
	                            </h5>
	                        </li>

	                        <!-- inner navigation to operate the user profile page -->
	                        <li class="nav-item">
	                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Timeline</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="pills-message-tab" data-toggle="pill" href="#pills-message" role="tab" aria-controls="pills-message" aria-selected="false">messages</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="false">photos</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="pills-friends-tab" data-toggle="pill" href="#pills-friends" role="tab" aria-controls="pills-friends" aria-selected="false">Friends</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="pills-event-tab" data-toggle="pill" href="#pills-event" role="tab" aria-controls="pills-event" aria-selected="false">Event</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab" aria-controls="pills-group" aria-selected="false">Group</a>
	                        </li>
	                        
	                        <!-- end of inner-inner navigation  -->
	                    </ul>
	                </div>
	                <!-- end of timelie info -->
	            </div>
	            <!-- end of div container for inner navigation  -->
	        </div>
	        <!-- end of row merged   -->
	    </div>
	    <!-- end of second navigation  -->
	</div>
	<!-- end of main section  -->
</section>
<!-- start new section -->
<section>
    <div class="gap gray-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="page-contents">
						<!-- left sidebar start -->
                        <div class="col-lg-3">
							<!-- shortcut navigation -->
                			<?php include("shortcut.php");?>
                           
                            <!-- end of aside colum -->
                        </div>
						<!-- end left sidebar -->

						<!-- main content area -->
                        <div class="col-lg-7">
                            <div class="loadMore">
                                <!-- load post if they are freinds -->
                                <div class="central-meta item">
                                    <?php 
										// if the person is freinds then only can view the post of the profile holder 
										$profile_student_object = new Student($connection, $student_name);  // create a profile object 
										if($profile_student_object->isBuddy($studentLogIn)) {//check whether it is friend by passing function
									?>
                                    <div class="tab-content" id="pills-tabContent">
                                        <!-- strat the timeline tab -->
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <!-- this tab contains the main timeline of the profile page -->
                                            <div class="new-postbox">
                                                <figure>
                                                    <img src="<?php echo $student['profile_pic']; ?>">
                                                </figure>
                                                <div class="newpost-input">
                                                    <form class="profile_post" action="" method="POST" enctype="multipart/form-data">
                                                        <textarea class="form-control" name="post_body" placeholder="Got something to say?" rows="2"></textarea>
                                                        <input type="hidden" name="created_by" value="<?php echo $studentLogIn; ?>">
                                                        <input type="hidden" name="student_to" value="<?php echo $student_name; ?>">
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
												$post->loadProfilePosts($student_name);
										
										?>
                                            <!-- end of profile timeline displayed -->
                                        </div>
                                        <!-- end of timeline tab -->

                                        <!--message tab start -->
                                        
                                        <!-- this pills display the messages -->
                                        <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-message-tab">
                                            <?php
												echo "<h4>You and <a href='" . $student_name ."'>" . $profile_student_object->getFirstAndLastName() . "</a></h4><hr><br>";
												echo "<div class='loaded_messages' id='scroll_messages'>";
												echo $message_object->getMessages($student_name);
												echo "</div>";
											?>
                                            <!-- message post form -->
                                            <div class="message_post">
                                                <form action="" method="POST">
                                                    <textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>
                                                    <input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
                                                </form>
                                            </div>
                                            <!-- end of message post form -->
                                            <!-- script to display the msg scroll-->
                                            <script>
                                                $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
													var div = document.getElementById("scroll_messages");
													div.scrollTop = div.scrollHeight;
												});
											</script>
                                            <!--end of msg scroll script -->
                                        </div>
                                        
                                        <!-- close div message tab -->

                                         <!-- start the gallery tab -->
                                        <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                                            <div class="row">
                                                <?php
													$query1=mysqli_query($connection,"SELECT * FROM images WHERE image_added ='$student_name' ");
													$i=0; 
													while($gallery_query = mysqli_fetch_array($query1)){
														$gallery_id = $gallery_query['id'];
														$gallery_image = $gallery_query['image'];
														$gallery_name = $gallery_query['image_added'];
														$i++;
												?>
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="thumbnail">
                                                        <a href="<?php echo $gallery_image; ?>" target="_blank">
                                                            <img src="<?php echo $gallery_image;?>" style="height:150px;width:200px;">
                                                        </a>
                                                        <?php
															if($studentLogIn == $student_name){
															//checks whether it is user logged in as we want to show edit button only to the user not to their friends 
														?>
                                                        <a href="profile.php?delete=<?php echo $gallery_id; ?>">
                                                            <button type="button" class="btn btn-danger" name="delete">Delete</button>
                                                        </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- close div gallery tab -->

                                        <!--friend tab -->
                                        <div class="tab-pane fade" id="pills-friends" role="tabpanel" aria-labelledby="pills-friends-tab">
										<br>
										<h3> Friends List </h3><br>
                                            <?php
        										$student_object = new Student($connection, $student_name);
        										foreach($student_object->getFriendsList() as $friend) {
        											$friend_object = new Student($connection, $friend);
        											echo "<a href='$friend'>
            											<img class='profilePicMiddle' src='" . $friend_object->getProfilePic() ."'>". $friend_object->getFirstAndLastName() . "</a> <br><hr>";
            									}
            								?>
                                        </div>
                                        <!--close friend tab -->
                                        <!--friend event-->
                                        <div class="tab-pane fade" id="pills-event" role="tabpanel" aria-labelledby="pills-event-tab">
                                            <div class="row">
                                                <?php
													$query1=mysqli_query($connection,"SELECT * FROM student_events WHERE created_by ='$student_name' AND event_status='friend' ");
													$i=0; 
													while($event_query = mysqli_fetch_array($query1)){
														$event_id = $event_query['event_id'];
														$event_name = $event_query['event_name'];
														$event_date = $event_query['event_date'];
														$event_time = $event_query['event_time'];
														$event_status=$event_query['event_status'];
														$event_description = $event_query['event_description'];
														$event_img=$event_query['event_pic'];
															
														$i++;		
												?>
                                                <div class="col-sm-8 col-md-4">
                                                    <div class="card-deck">
                                                        <!-- set a width on the image otherwise it will expand to full width       -->
                                                        <img class="card-img-top" src="<?php echo $event_img;?>" alt="Card image cap" style="width: 260px;height: 200px;">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><label>Event : </label>
                                                                <?php echo $event_name; ?>
                                                            </h5>
                                                            <h6><label>Date : </label>
                                                                <?php echo $event_date; ?>
                                                            </h6>
                                                            <h6><label>Time : </label>
                                                                <?php echo $event_time; ?>
                                                            </h6>
                                                            <p class="card-text"><label>Info : </label>
                                                                <?php echo $event_description; ?>
                                                            </p>
                                                            <?php
															if($studentLogIn == $student_name){
															//checks whether it is user logged in as we want to show edit button only to the user not to their friends 
														?>
                                                            <a href="event.php?delete=<?php echo $event_id; ?>">
                                                                <button type="button" class="btn btn-danger" name="delete">Delete</button>
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!--close friend event-->
                                        <!-- group of friend -->
                                        <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                                            <div class="row">
                                                <?php
													$query1=mysqli_query($connection,"SELECT * FROM group_entry WHERE created_by ='$student_name' AND group_status='friend'");
													$i=0; 
													while($group_query = mysqli_fetch_array($query1)){
														$group_id = $group_query['group_id'];
														$group_name = $group_query['group_name'];
														$group_created=$group_query['created_by'];
														$group_image = $group_query['profile_pics'];
														$i++;		
												?>
                                                <div class="col-sm-8 col-md-4">
                                                    <div class="card-deck">
                                                        <!-- set a width on the image otherwise it will expand to full width       -->
                                                        <img class="card-img-top" src="<?php echo $group_image; ?>" alt="Card image cap" style="width: 260px;height: 200px;">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                            	<label>Group: </label>
                                                                <?php echo $group_name; ?>
                                                            </h5>
                                                            <h6>
                                                            	<label>created : </label>
                                                                <?php echo $group_created; ?>
                                                            </h6>
                                                            <?php
															if($studentLogIn == $student_name){
															//checks whether it is user logged in as we want to show edit button only to the user not to their friends 
														?>
                                                            <a href="group.php?delete=<?php echo $group_id; ?>">
                                                                <button type="button" class="btn btn-danger" name="delete">Delete</button>
                                                            </a>
                                                            <?php
															}?>
                                                            <a href="group_view.php?view=<?php echo $group_id; ?>">
                                                                <button type="button" class="btn btn-success" name="view">view</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!--close group friend-->
                                    </div>
                                    <!-- close tab -->
                            		<?php 
										}
										else{
											echo "<h4>". $student_array['first_name'] . " " . $student_array['last_name']."   is not in your Friend list </h4>";
										}
									?>
								</div><!-- centerl meta -->
								<!-- ajax request to load the profile post of the user -->
								
                    		</div>
                    		<!-- end of loadmore class -->
               			</div>
                		<!--end of the middle section -->

                		<!-- right sidebar -->
                		<div class="col-lg-2">
						 <aside class="sidebar static">
                                <!-- profile info start -->
                                <div class="widget">
                                    <h4 class="widget-title">Profile Info</h4>
									
                                    <div class="profile_info_small">
                                       
                                        <p>
                                            <?php echo "Posts: " . $student_array['num_posts']; ?>
                                        </p>
                                        <p>
                                            <?php echo "Likes: " . $student_array['num_likes']; ?>
                                        </p>
										
                          
                                    </div>
                                </div>
                                <!-- profile info end  -->
                            </aside>
                			<aside class="sidebar static">
									<div class="widget ">
										<h4 class="widget-title">Friends</h4>
										<?php
											$student_object = new Student($connection, $student_name);
											foreach($student_object->getFriendsList() as $friend) {
											 
												$friend_object = new Student($connection, $friend);
											 
												echo "<a href='$friend'>
														<img class='profilePicSmall' src='" . $friend_object->getProfilePic() ."'>"
														. $friend_object->getFirstAndLastName() . 
													"</a>
													<br>";
											}
											?>
										<div id="searchDir"></div>
									</div><!-- friends list sidebar -->
								</aside>
                		</div><!-- sidebar -->
            		</div><!-- page contain id  -->
       			</div>
        		<!--row closed -->
    		</div>
    	</div><!-- close cotainer fluid -->
    </div><!-- close gap -->
</section>
<!-- close the section -->
</body>

</html>
