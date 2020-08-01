<?php
class Group {
	private $student_object;
	private $connection;
	public $view_id;
	
	

	public function __construct($connection, $student){
		$this->connection = $connection;
		$this->student_object = new Student($connection, $student);
		if(isset($_GET['view'])) {
			$this->view_id = $_GET['view'];
		}else{
			$this->view_id = null;
		}
	}
	
	public function submitGroup($body, $student_to) {
		$date_added = date("Y-m-d H:i:s");
		$body = strip_tags($body); //removes html tags 
		$body = mysqli_real_escape_string($this->connection, $body);
		$check_empty = preg_replace('/\s+/', '', $body); //Deltes all spaces 
      
		if($check_empty != "") {

			//Current date and time
			$date_added = date("Y-m-d H:i:s");
			//Get username
			$created_by = $this->student_object->getStudent_name();

			//If user is on own profile, user_to is 'none'
			if($student_to == $created_by) {
				$student_to = "none";
			}

			//insert post 
			$query = mysqli_query($this->connection, "INSERT INTO group_post VALUES('', '$body', '$created_by','$student_to', '$date_added', 'no', '$this->view_id')");
			$returned_id = mysqli_insert_id($this->connection);
		}
		
	}

	public function loadGroupPosts(){

$studentLogIn = $this->student_object->getStudent_name();
		$output = ""; //String to return 
		$data_query = mysqli_query($this->connection, "SELECT * FROM group_post WHERE group_id='$this->view_id'  ORDER BY id DESC")or die (mysqli($this->connection));

		if(mysqli_num_rows($data_query) > 0) {


			$num_checks = 0; //Number of results checked (not necasserily posted)
			$count = 1;

			while($row = mysqli_fetch_array($data_query)) {
				$id = $row['id'];
				$body = $row['group_content'];
				$created_by = $row['student_from'];
				$date_time = $row['date_added'];


					
					if($studentLogIn == $created_by){
						$delete_button = "<a href='includes/form_handlers/delete_group_post.php?delete=$id' > <button class='btn btn-outline-danger'>Delete</button></a>";
						$edit_button = "<a href='group_edit.php?edit=$id' ><button class='btn btn-outline-warning'>Edit</button></a>";
						$report_button ="";	
			}else {
						$delete_button = "";
					$edit_button ="";
					$report_button = "<a href='includes/form_handlers/delete_group_post.php?report=$id' ><button class='btn btn-outline-danger'>Report</button></a>";
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
		$start_date = new DateTime($row['date_added']); //Time of post
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

					$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
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


			} //End while loop

			
		}

		echo $output;


	}


}

?>