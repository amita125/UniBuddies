<?php
include("includes/header.php");
 
//Get student_name parameter from url
if(isset($_GET['student_name'])) {
    $student_name = $_GET['student_name'];
}
else {
    $student_name = $studentLogIn; //If no student_name set in url, use student logged in instead
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
									<h4> Your Friends </h4>	 

											<?php
											$student_object = new Student($connection, $student_name);
											 
											foreach($student_object->getFriendsList() as $friend) {
											 
												$friend_object = new Student($connection, $friend);
											 
												echo "<a href='$friend'>
														<img class='profilePicMiddle' src='" . $friend_object->getProfilePic() ."'>"
														. $friend_object->getFirstAndLastName() . 
													"</a>
													<br><hr>";
											}
											?>

									</div>
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