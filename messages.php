<?php 
include("includes/header.php");

$message_object = new Message($connection, $studentLogIn);

if(isset($_GET['profile_student_name']))
	$student_to = $_GET['profile_student_name'];
else {
	$student_to = $message_object->getRecentStudent();
	if($student_to == false)
		$student_to = 'new';
}

if($student_to != "new")
	$student_to_object = new Student($connection, $student_to);

if(isset($_POST['post_message'])) {

	if(isset($_POST['message_body'])) {
		$body = mysqli_real_escape_string($connection, $_POST['message_body']);
		$date = date("Y-m-d H:i:s");
		$message_object->sendMessage($student_to, $body, $date);
		
	}
	header("Location: messages.php");

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
		if($student_to != "new"){
			echo "<h4>You and <a href='$student_to'>" . $student_to_object->getFirstAndLastName() . "</a></h4><hr><br>";

			echo "<div class='loaded_messages' id='scroll_messages'>";
				echo $message_object->getMessages($student_to);
			echo "</div>";
		}
		else {
			echo "<h4>New Message</h4>";
		}
		?>



		<div class="message_post">
			<form action="" method="POST">
				<?php
				
					echo "<textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>";
					echo "<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>";
				

				?>
			</form>

		</div>

		<script>
			var div = document.getElementById("scroll_messages");
			div.scrollTop = div.scrollHeight;
		</script>
									</div>
								</div>
							</div><!-- centerl meta -->

							<div class="col-lg-3">
								<aside class="sidebar static">
									
									<div class="widget">
									<div class="user_details column" id="conversations">
			<h4>Conversations</h4>

			<div class="loaded_conversations">
				<?php echo $message_object->getTalks(); ?>
			</div>
			<br>
			
		</div>

									</div><!-- profile intro widget -->

								</aside>
								<aside class="sidebar static">
								<div class="widget ">
										<h4 class="widget-title">Friends</h4>
										<?php
											$student_object = new Student($connection, $studentLogIn);
 
foreach($student_object->getFriendsList() as $friend) {
 
    $friend_object = new Student($connection, $friend);
 
    echo "
	<a href='$friend'>
            <img class='profilePicSmall' src='" . $friend_object->getProfilePic() ."'>"
            . $friend_object->getFirstAndLastName() . 
        "</a>
        <br>";
}
?>
									</div><!-- friends list sideb
								
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