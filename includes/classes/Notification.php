<?php
class Notification {
	private $student_object;
	private $connection;

	public function __construct($connection, $student){
		$this->connection = $connection;
		$this->student_object = new Student($connection, $student);
	}

	public function getUnreadNumber() {
		$studentLogIn = $this->student_object->getStudent_name();
		$query = mysqli_query($this->connection, "SELECT * FROM student_alert WHERE alert_viewed='no' AND student_to='$studentLogIn'");
		return mysqli_num_rows($query);
	}

	public function getNotifications() {

		$studentLogIn = $this->student_object->getStudent_name();
		$output = "";

		

		$set_viewed_query = mysqli_query($this->connection, "UPDATE student_alert SET alert_viewed='yes' WHERE student_to='$studentLogIn'");

		$query = mysqli_query($this->connection, "SELECT * FROM student_alert WHERE student_to='$studentLogIn' ORDER BY alert_id DESC");

		if(mysqli_num_rows($query) == 0) {
			echo "You have no student_alert!";
			return;
		}

		$num_check = 0; //Number of messages checked 
		$count = 1; //Number of messages posted

		while($row = mysqli_fetch_array($query)) {

			


			$student_from = $row['student_from'];

			$student_data_query = mysqli_query($this->connection, "SELECT * FROM students WHERE student_name='$student_from'")or die( mysqli_error($this->connection));
			
			$student_data = mysqli_fetch_array($student_data_query);


			//Timeframe
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($row['datetime']); //Time of post
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

			$alert_opened = $row['alert_opened'];
			$style = ($alert_opened == 'no') ? "background-color: #DDEDFF;" : "";

			$output .= "<a href='" . $row['link'] . "'> 
									<div class='resultDisplay resultDisplayNotification' style='" . $style . "'>
										<div class='notificationsProfilePic'>
											<img src='" . $student_data['profile_pic'] . "'>
										</div>
										<p class='timestamp_smaller' id='grey'>" . $time_message . "</p>" . $row['student_message'] . "
									</div>
								</a>";
		}


		//If posts were loaded
		

		return $output;
	}

	public function insertNotification($post_id, $student_to, $type) {

		$studentLogIn = $this->student_object->getStudent_name();
		$studentLogInName = $this->student_object->getFirstAndLastName();

		$date_time = date("Y-m-d H:i:s");

		switch($type) {
			case 'comment':
				$message = $studentLogInName . " commented on your post";
				break;
			case 'like':
				$message = $studentLogInName . " liked your post";
				break;
			case 'profile_post':
				$message = $studentLogInName . " posted on your profile";
				break;
			case 'comment_non_owner':
				$message = $studentLogInName . " commented on a post you commented on";
				break;
			case 'profile_comment':
				$message = $studentLogInName . " commented on your profile post";
				break;
		}

		$link = "post.php?post_id=" . $post_id;

		$insert_query = mysqli_query($this->connection, "INSERT INTO student_alert VALUES('', '$student_to', '$studentLogIn', '$message', '$link', '$date_time', 'no', 'no')");
	}

}

?>