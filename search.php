<?php

include("includes/header.php");
$output='';
if(isset($_POST['search'])) {
	$search_query = $_POST['query'];
	$search_query= preg_replace("#[^0-9a-z]#i","", $search_query);
	$query1 = mysqli_query($connection,"SELECT * FROM students WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' ")or die( mysqli_error($connection));
	$count= mysqli_num_rows($query1);
	if($count==0){
		$output= 'there is no result ';
	}else{
		while($row=mysqli_fetch_array($query1)){
			$student_object = new Student($connection, $student['student_name']);

			$button = "";
			$common_friends = "";

			if($student['student_name'] != $row['student_name']) {

				//Generate button depending on friendship status 
				if($student_object->isBuddy($row['student_name']))
					$button = "<input type='submit' name='" . $row['student_name'] . "' class='danger' value='Remove Friend'>";
				else if($student_object->didReceiveRequest($row['student_name']))
					$button = "<input type='submit' name='" . $row['student_name'] . "' class='warning' value='Respond to request'>";
				else if($student_object->didSendRequest($row['student_name']))
					$button = "<input type='submit' class='default' value='Request Sent'>";
				else 
					$button = "<input type='submit' name='" . $row['student_name'] . "' class='success' value='Add Friend'>";

				$common_friends = $student_object->getCommonFriends($row['student_name']) . " friends in common";


			

			}

			$output.="<div class='search_result'>
					
					<div class='result_profile_pic'>
						<a href='" . $row['student_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
					</div>

						<a href='" . $row['student_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
						<p id='grey'> " . $row['student_name'] ."</p>
						</a>
						<br>
						<br>

				</div>
				<hr id='search_hr'>";
		}
	}
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
										<?php 

											echo $output;

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