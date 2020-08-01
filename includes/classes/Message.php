<?php
class Message {
	private $student_object;
	private $connection;

	public function __construct($connection, $student){
		$this->connection = $connection;
		$this->student_object = new Student($connection, $student);
	}

	public function getRecentStudent() {
		$studentLogIn = $this->student_object->getStudent_name();

		$query = mysqli_query($this->connection, "SELECT student_to, student_from FROM messages WHERE student_to='$studentLogIn' OR student_from='$studentLogIn' ORDER BY message_id DESC LIMIT 1");

		if(mysqli_num_rows($query) == 0)
			return false;

		$row = mysqli_fetch_array($query);
		$student_to = $row['student_to'];
		$student_from = $row['student_from'];

		if($student_to != $studentLogIn)
			return $student_to;
		else 
			return $student_from;

	}

	public function sendMessage($student_to, $body, $date) {

		if($body != "") {
			$studentLogIn = $this->student_object->getStudent_name();
			$query = mysqli_query($this->connection, "INSERT INTO messages VALUES('', '$student_to', '$studentLogIn', '$body', '$date', 'no', 'no')");
		}
	}

	public function getMessages($otherStudent) {
		$studentLogIn = $this->student_object->getStudent_name();
		$output = "";

		$query = mysqli_query($this->connection, "UPDATE messages SET message_opened='yes' WHERE student_to='$studentLogIn' AND student_from='$otherStudent'");

		$get_messages_query = mysqli_query($this->connection, "SELECT * FROM messages WHERE (student_to='$studentLogIn' AND student_from='$otherStudent') OR (student_from='$studentLogIn' AND student_to='$otherStudent')");

		while($row = mysqli_fetch_array($get_messages_query)) {
			$student_to = $row['student_to'];
			$student_from = $row['student_from'];
			$body = $row['message_content'];

			$div_top = ($student_to == $studentLogIn) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";
			$output = $output . $div_top . $body . "</div><br><br>";
		}
		return $output;
	}

	public function getLatestMessage($studentLogIn, $student2) {
		$details_array = array();

		$query = mysqli_query($this->connection, "SELECT message_content, student_to, message_date FROM messages WHERE (student_to='$studentLogIn' AND student_from='$student2') OR (student_to='$student2' AND student_from='$studentLogIn') ORDER BY message_id DESC LIMIT 1");

		$row = mysqli_fetch_array($query);
		$sent_by = ($row['student_to'] == $studentLogIn) ? "They said: " : "You said: ";

		//Timeframe
		$date_time_now = date("Y-m-d H:i:s");
		$start_date = new DateTime($row['message_date']); //Time of post
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

		array_push($details_array, $sent_by);
		array_push($details_array, $row['message_content']);
		array_push($details_array, $time_message);

		return $details_array;
	}

	public function getTalks() {
		$studentLogIn = $this->student_object->getStudent_name();
		$output = "";
		$talks = array();

		$query = mysqli_query($this->connection, "SELECT student_to, student_from FROM messages WHERE student_to='$studentLogIn' OR student_from='$studentLogIn' ORDER BY message_id DESC");

		while($row = mysqli_fetch_array($query)) {
			$student_to_push = ($row['student_to'] != $studentLogIn) ? $row['student_to'] : $row['student_from'];

			if(!in_array($student_to_push, $talks)) {
				array_push($talks, $student_to_push);
			}
		}

		foreach($talks as $student_name) {
			$student_found_object = new Student($this->connection, $student_name);
			$latest_message_details = $this->getLatestMessage($studentLogIn, $student_name);

			$dots = (strlen($latest_message_details[1]) >= 4) ? "..." : "";
			$split = str_split($latest_message_details[1], 4);
			$split = $split[0] . $dots; 

			$output .= "<a href='messages.php?profile_student_name=$student_name'> <div class='student_found_messages'>
								<img  class='profilePicSmall' src='" . $student_found_object->getProfilePic() . "' style='border-radius: 5px; margin-right: 5px;'>
								" . $student_found_object->getFirstAndLastName() . "
								<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
								<p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
								</div>
								</a>";
		}

		return $output;

	}

	public function getTalksNotify() {

		
		$studentLogIn = $this->student_object->getStudent_name();
		$output = "";
		$talks = array();

		

		$set_viewed_query = mysqli_query($this->connection, "UPDATE messages SET message_viewed='yes' WHERE student_to='$studentLogIn'");

		$query = mysqli_query($this->connection, "SELECT student_to, student_from FROM messages WHERE student_to='$studentLogIn' OR student_from='$studentLogIn' ORDER BY message_id DESC")or die( mysqli_error($this->connection));

		while($row = mysqli_fetch_array($query)) {
			$student_to_push = ($row['student_to'] != $studentLogIn) ? $row['student_to'] : $row['student_from'];

			if(!in_array($student_to_push, $talks)) {
				array_push($talks, $student_to_push);
			}
		}

		

		foreach($talks as $student_name) {

			

			$is_unread_query = mysqli_query($this->connection, "SELECT message_opened FROM messages WHERE student_to='$studentLogIn' AND student_from='$student_name' ORDER BY message_id DESC")or die( mysqli_error($this->connection));
			$row = mysqli_fetch_array($is_unread_query);
			$style = ($row['message_opened'] == 'no') ? "background-color: #7bed9f;" : "";


			$student_found_object = new Student($this->connection, $student_name);
			$latest_message_details = $this->getLatestMessage($studentLogIn, $student_name);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots; 

			$output .= "<a href='messages.php?u=$student_name'> 
								<div class='student_found_messages' style='" . $style . "'>
								<img src='" . $student_found_object->getProfilePic() . "' style='border-radius: 5px; margin-right: 5px; height:50px;width:50px;'>
								" . $student_found_object->getFirstAndLastName() . "
								<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
								<p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
								</div>
								</a>";
		}


		//If posts were loaded
		

		return $output;
	}

	public function getUnreadNumber() {
		$studentLogIn = $this->student_object->getStudent_name();
		$query = mysqli_query($this->connection, "SELECT * FROM messages WHERE message_viewed='no' AND student_to='$studentLogIn'");
		return mysqli_num_rows($query);
	}

}

?>