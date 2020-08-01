<?php
include("includes/header.php"); //Header 
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
									<h4>Friend Requests</h4>

	<?php  

	$query = mysqli_query($connection, "SELECT * FROM requests WHERE student_to='$studentLogIn'");
	if(mysqli_num_rows($query) == 0)
		echo "You have no friend requests at this time!";
	else {

		while($row = mysqli_fetch_array($query)) {
			$student_from = $row['student_from'];
			$student_from_object = new Student($connection, $student_from);

			echo $student_from_object->getFirstAndLastName() . " sent you a friend request!";

			$student_from_friend_array = $student_from_object->getFriends();

			if(isset($_POST['accept_request' . $student_from ])) {
				$add_friend_query = mysqli_query($connection, "UPDATE students SET friend_array=CONCAT(friend_array, '$student_from,') WHERE student_name='$studentLogIn'");
				$add_friend_query = mysqli_query($connection, "UPDATE students SET friend_array=CONCAT(friend_array, '$studentLogIn,') WHERE student_name='$student_from'");

				$delete_query = mysqli_query($connection, "DELETE FROM requests WHERE student_to='$studentLogIn' AND student_from='$student_from'");
				echo "You are now friends!";
				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $student_from ])) {
				$delete_query = mysqli_query($connection, "DELETE FROM requests WHERE student_to='$studentLogIn' AND student_from='$student_from'");
				echo "Request ignored!";
				header("Location: requests.php");
			}

			?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept_request<?php echo $student_from; ?>" id="accept_button" value="Accept">
				<input type="submit" name="ignore_request<?php echo $student_from; ?>" id="ignore_button" value="Ignore">
			</form>
			<?php


		}

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