<?php

class Post {
	private $student_object;
	private $connection;

	public function __construct($connection, $student){
		$this->connection = $connection;
		$this->student_object = new Student($connection, $student);
	}

	public function submitPost($body, $student_to, $imageName) {
		$body = strip_tags($body); //removes html tags 
		$body = mysqli_real_escape_string($this->connection, $body);
		$check_empty = preg_replace('/\s+/', '', $body); //Deltes all spaces 
      
		if($check_empty != "" || $imageName !="") {

			//Current date and time
			$date_added = date("Y-m-d H:i:s");
			//Get student_name
			$created_by = $this->student_object->getStudent_name();

			//If user is on own profile, user_to is 'none'
			if($student_to == $created_by)
				$student_to = "none";

			//insert post 
			$query = mysqli_query($this->connection, "INSERT INTO student_posts VALUES('', '$body', '$created_by', '$student_to', '$date_added', 'no',  '0', '$imageName')");
			$returned_id = mysqli_insert_id($this->connection);

			//Insert notification
			if($student_to != 'none') {
				$notification = new Notification($this->connection, $created_by);
				$notification->insertNotification($returned_id, $student_to, "like");
			}

			//Update post count for user 
			$num_posts = $this->student_object->getNumPosts();
			$num_posts++;
			$update_query = mysqli_query($this->connection, "UPDATE students SET num_posts='$num_posts' WHERE student_name='$created_by'");

		}
	}

	

	public function loadPosts() {
		$studentLogIn = $this->student_object->getStudent_name();
		$output = ""; //String to return 
		$data_query = mysqli_query($this->connection, "SELECT * FROM student_posts  ORDER BY post_id DESC");

		if(mysqli_num_rows($data_query) > 0) {
			
			while($row = mysqli_fetch_array($data_query)) {
				$id = $row['post_id'];
				$body = $row['post_content'];
				$created_by = $row['created_by'];
				$date_time = $row['date_added'];
				$imagePath = $row['post_image'];

				//Prepare user_to string so it can be included even if not posted to a user
				if($row['student_to'] == "none") {
					$student_to = "";
				}
				else {
					$student_to_object = new Student($this->connection, $row['student_to']);
					$student_to_name = $student_to_object->getFirstAndLastName();
					$student_to = "to <a href='" . $row['student_to'] ."'>" . $student_to_name . "</a>";
				}

				//Check if user who posted, has their account closed
				$created_by_object = new Student($this->connection, $created_by);
				if($created_by_object->accountClosed()) {
					continue;
				}

				$student_logged_object = new Student($this->connection, $studentLogIn);
				if($student_logged_object->isBuddy($created_by)){


					
					
					if($studentLogIn == $created_by){
						$delete_button = "<a href='includes/form_handlers/delete_post.php?delete=$id' > <button class='btn btn-outline-danger'>Delete</button></a>";
						$edit_button = "<a href='post_edit.php?edit=$id' ><button class='btn btn-outline-warning'>Edit</button></a>";
						$report_button ="";
						
			}else {
						$delete_button = "";
					$edit_button ="";
					$report_button = "<a href='includes/form_handlers/delete_post.php?report=$id' ><button class='btn btn-outline-danger'>Report</button></a>";
			}


					$student_details_query = mysqli_query($this->connection, "SELECT first_name, last_name, profile_pic FROM students WHERE student_name='$created_by'");
					$student_row = mysqli_fetch_array($student_details_query);
					$first_name = $student_row['first_name'];
					$last_name = $student_row['last_name'];
					$profile_pic = $student_row['profile_pic'];


					?>
					<script> 
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}

					</script>
					<?php

					$comments_check = mysqli_query($this->connection, "SELECT * FROM student_comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval->y == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month ". $days;
						}
						else {
							$time_message = $interval->m . " months ". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					if($imagePath != "") {
						$imageDiv = "<div class='postedImage'>
										<img src='$imagePath'>
									</div>";
					}
					else {
						$imageDiv = "";
					}

					$output .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$created_by'> $first_name $last_name </a> $student_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
									$edit_button
									$report_button
								</div>
								<div id='post_body'>
									$body
									<br>
									$imageDiv
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
				}

				

			} 
		}

		echo $output;
	}


	public function loadProfilePosts() {

		$studentLogIn = $this->student_object->getStudent_name();
		if(isset($_GET['profile_student_name'])) {
		$student_profile = $_GET['profile_student_name'];
		}
		$output = ""; //String to return 
		$data_query = mysqli_query($this->connection, "SELECT * FROM student_posts WHERE ((created_by='$student_profile' AND student_to='none') OR student_to='$student_profile')  ORDER BY post_id DESC")or die( mysqli_error($this->connection));

		if(mysqli_num_rows($data_query) > 0) {

			while($row = mysqli_fetch_array($data_query)) {
				$id = $row['post_id'];
				$body = $row['post_content'];
				$created_by = $row['created_by'];
				$date_time = $row['date_added'];
				$imagePath = $row['post_image'];

					if($studentLogIn == $created_by){
						$delete_button = "<a href='includes/form_handlers/delete_post.php?delete1=$id' > <button class='btn btn-outline-danger'>Delete</button></a>";
						$edit_button = "<a href='post_edit.php?edit=$id' ><button class='btn btn-outline-warning'>Edit</button></a>";
						$report_button ="";
						
			}else {
						$delete_button = "";
					$edit_button ="";
					$report_button = "<a href='includes/form_handlers/delete_post.php?report=$id' ><button class='btn btn-outline-danger'>Report</button></a>";
			}

					$student_details_query = mysqli_query($this->connection, "SELECT first_name, last_name, profile_pic FROM students WHERE student_name='$created_by'");
					$student_row = mysqli_fetch_array($student_details_query);
					$first_name = $student_row['first_name'];
					$last_name = $student_row['last_name'];
					$profile_pic = $student_row['profile_pic'];

					?>
					<script> 
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}

					</script>
					<?php

					$comments_check = mysqli_query($this->connection, "SELECT * FROM student_comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval->y == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					if($imagePath != "") {
						$imageDiv = "<div class='postedImage'>
										<img src='$imagePath'>
									</div>";
					}
					else {
						$imageDiv = "";
					}

					$output .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$created_by'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
									$edit_button
									$report_button
								</div>
								<div id='post_body'>
									$body
									<br>
									$imageDiv
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
			} 
		}

		echo $output;


	}

	public function getSinglePost($post_id) {

		$studentLogIn = $this->student_object->getstudent_name();

		$opened_query = mysqli_query($this->connection, "UPDATE notifications SET opened='yes' WHERE student_to='$studentLogIn' AND link LIKE '%=$post_id'");

		$output = ""; //String to return 
		$data_query = mysqli_query($this->connection, "SELECT * FROM student_posts WHERE post_id='$post_id'");

		if(mysqli_num_rows($data_query) > 0) {


			$row = mysqli_fetch_array($data_query); 
				$id = $row['post_id'];
				$body = $row['post_content'];
				$created_by = $row['created_by'];
				$date_time = $row['date_added'];

				//Prepare user_to string so it can be included even if not posted to a user
				if($row['student_to'] == "none") {
					$student_to = "";
				}
				else {
					$student_to_object = new Student($this->connection, $row['student_to']);
					$student_to_name = $student_to_object->getFirstAndLastName();
					$student_to = "to <a href='" . $row['student_to'] ."'>" . $student_to_name . "</a>";
				}

				//Check if user who posted, has their account closed
				$created_by_object = new Student($this->connection, $created_by);
				if($created_by_object->accountClosed()) {
					return;
				}

				$student_logged_object = new Student($this->connection, $studentLogIn);
				if($student_logged_object->isBuddy($created_by)){


					if($studentLogIn == $created_by){
						$delete_button = "<a href='includes/form_handlers/delete_post.php?delete=$id' > <button class='btn btn-outline-danger'>Delete</button></a>";
						$edit_button = "<a href='post_edit.php?edit=$id' ><button class='btn btn-outline-warning'>Edit</button></a>";
						$report_button ="";
						
			}else {
						$delete_button = "";
					$edit_button ="";
					$report_button = "<a href='includes/form_handlers/delete_post.php?report=$id' ><button class='btn btn-outline-danger'>Report</button></a>";
			}


					$student_details_query = mysqli_query($this->connection, "SELECT first_name, last_name, profile_pic FROM students WHERE student_name='$created_by'");
					$student_row = mysqli_fetch_array($student_details_query);
					$first_name = $student_row['first_name'];
					$last_name = $student_row['last_name'];
					$profile_pic = $student_row['profile_pic'];


					?>
					<script> 
						function toggle<?php echo $id; ?>(e) {

 							if( !e ) e = window.event;

							var target = $(e.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}

					</script>
					<?php

					$comments_check = mysqli_query($this->connection, "SELECT * FROM student_comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$output .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$created_by'> $first_name $last_name </a> $student_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
									$edit_button
									$report_button
								</div>
								
								<div id='post_body'>
									$body
									<br>
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";


				}
				else {
					echo "<p>You cannot see this post because you are not friends with this user.</p>";
					return;
				}
		}
		else {
			echo "<p>No post found. If you clicked a link, it may be broken.</p>";
					return;
		}

		echo $output;
	}



}

?>