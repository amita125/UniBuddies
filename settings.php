	<?php

		include("includes/header.php");
		include("includes/form_handlers/settings_handler.php");
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
							<div class="col-lg-7">
								<div class="loadMore">
									<div class="central-meta item">
										<h3> Personal Info </h3>
										<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
											<li class="nav-item">
    											<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Basic info </a>
  											</li>
  											<li class="nav-item">
    											<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Password</a>
  											</li>
										</ul>
										
										<div class="tab-content" id="pills-tabContent">
										  	<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
	
										  		<br>
										  		
										  		<br>
												<?php
													$student_data_query = mysqli_query($connection, "SELECT gender,birthday,level,course FROM students WHERE student_name='$studentLogIn'");
													$row = mysqli_fetch_array($student_data_query);

													$gender = $row['gender'];
													$birthday = $row['birthday'];
													$level = $row['level'];
													$course = $row['course'];
													?>
										  		<form action="settings.php" method="POST">
										  			<fieldset>
										  				<legend>Personal:</legend>
															<label>Gender :  </label> 
																<input type="radio" name="gender" value="female" checked>Female									
																<input type="radio" name="gender" value="male">Male
																<br>
															<label>Birthday: </label>
																<input type="date" name="birthday" >
																<br>
															
													</fieldset>
													<fieldset>
														<legend>Education : </legend>
														<br>
														<label>Course name :</label>
															<input type="text" name="course" required>
															<br>

														<label> Year of study </label>
														<input type="radio" name="level" value="4" checked>	4														
															<input type="radio" name="level" value="5">5
															<input type="radio" name="level" value="6">6
															<input type="radio" name="level" value="7">7
															<br>
															<?php echo $message; ?>

													</fieldset>
														<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
													</form>
										  	</div>
										  
										  	<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
												
												<form action="settings.php" method="POST">
													<fieldset>
										  				<legend>Change Password</legend>
										  				<label>Old Password:</label>
										  				<input type="password" name="old_password" id="settings_input"><br>
										  				<label>New Password:</label>
										<input type="password" name="new_password_1" id="settings_input"><br>
										<label>New Password Again:</label>
										 <input type="password" name="new_password_2" id="settings_input"><br>

										<?php echo $password_message; ?>

										<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
									</form>

									<h4>Close Account</h4>
									<form action="settings.php" method="POST">
										<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
									</form>

										  	</div>

										</div>
									</div>
								</div>	
							</div><!-- centerl meta -->
							<div class="col-lg-2">
								
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</body>
</html>