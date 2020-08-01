<?php
class Student {
	private $student;
	private $connection;

	public function __construct($connection, $student){
		$this->connection = $connection;
		$student_details_query = mysqli_query($connection, "SELECT * FROM students WHERE student_name='$student'");
		$this->student = mysqli_fetch_array($student_details_query);
	}

	public function getStudent_name() {
		return $this->student['student_name'];
	}

	public function getNumOfFriendRequests() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT * FROM requests WHERE student_to='$student_name'");
		return mysqli_num_rows($query);
	}

	public function getNumPosts() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT num_posts FROM students WHERE student_name='$student_name'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
	}

	public function getFirstAndLastName() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT first_name, last_name FROM students WHERE student_name='$student_name'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	public function getProfilePic() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT profile_pic FROM students WHERE student_name='$student_name'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'];
	}

	public function getFriends() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT friend_array FROM students WHERE student_name='$student_name'");
		$row = mysqli_fetch_array($query);
		return $row['friend_array'];
	}

	public function accountClosed() {
		$student_name = $this->student['student_name'];
		$query = mysqli_query($this->connection, "SELECT user_closed FROM students WHERE student_name='$student_name'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'yes')
			return true;
		else 
			return false;
	}

	public function isBuddy($student_name_to_check) {
		$student_nameComma = "," . $student_name_to_check . ",";

		if((strstr($this->student['friend_array'], $student_nameComma) || $student_name_to_check == $this->student['student_name'])) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didReceiveRequest($student_from) {
		$student_to = $this->student['student_name'];
		$check_request_query = mysqli_query($this->connection, "SELECT * FROM requests WHERE student_to='$student_to' AND student_from='$student_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($student_to) {
		$student_from = $this->student['student_name'];
		$check_request_query = mysqli_query($this->connection, "SELECT * FROM requests WHERE student_to='$student_to' AND student_from='$student_from'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function unFriend($student_to_remove) {
		$logged_in_student = $this->student['student_name'];

		$query = mysqli_query($this->connection, "SELECT friend_array FROM students WHERE student_name='$student_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_student_name = $row['friend_array'];

		$new_friend_array = str_replace($student_to_remove . ",", "", $this->student['friend_array']);
		$remove_friend = mysqli_query($this->connection, "UPDATE students SET friend_array='$new_friend_array' WHERE student_name='$logged_in_student'");

		$new_friend_array = str_replace($this->student['student_name'] . ",", "", $friend_array_student_name);
		$remove_friend = mysqli_query($this->connection, "UPDATE students SET friend_array='$new_friend_array' WHERE student_name='$student_to_remove'");
	}

	public function sendRequest($student_to) {
		$student_from = $this->student['student_name'];
		$query = mysqli_query($this->connection, "INSERT INTO requests VALUES('', '$student_to', '$student_from')");
	}

	public function getCommonFriends($student_to_check) {
		$commonFriends = 0;
		$student_array = $this->student['friend_array'];
		$student_array_explode = explode(",", $student_array);

		$query = mysqli_query($this->connection, "SELECT friend_array FROM students WHERE student_name='$student_to_check'");
		$row = mysqli_fetch_array($query);
		$student_to_check_array = $row['friend_array'];
		$student_to_check_array_explode = explode(",", $student_to_check_array);

		foreach($student_array_explode as $i) {

			foreach($student_to_check_array_explode as $j) {

				if($i == $j && $i != "") {
					$commonFriends++;
				}
			}
		}
		return $commonFriends;

	}

	public function getFriendsList() {
		
		$friend_array_string = $this->student['friend_array']; //Get friend array string from table
	 
		$friend_array_string = trim($friend_array_string, ","); //Remove first and last comma
	 
		return explode(",", $friend_array_string); //Split to array at each comma
	}


}

?>