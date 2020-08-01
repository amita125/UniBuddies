	<?php

		include("includes/header.php");

		if (isset($_SESSION['student_name'])){

			$student_name=$_SESSION['student_name'];
			
			if(isset($_POST['submit'])){
				
				$e_title = strip_tags($_POST['event_title']); //Remove html tags
				$e_title = ucfirst(strtolower($e_title)); //Uppercase first letter
				
				$e_des  = strip_tags($_POST['event_description']); //removes html tags 
				$e_des = mysqli_real_escape_string($e_des);
		
				$e_date = $_POST['event_date'];
				$e_time = $_POST['event_time'];
				$e_status = $_POST['event_radio'];
				
				$rand = rand(1, 5); //Random number between 1 and 2
				if($rand == 1)
					$e_pic = "assets/images/event/event-1.jpg";
				else if($rand == 2)
					$e_pic = "assets/images/event/event-2.jpg";
				else if($rand == 3)
					$e_pic = "assets/images/event/event-3.jpg";
				else if($rand == 4)
					$e_pic = "assets/images/event/event-4.jpg";
				else if($rand == 5)
					$e_pic = "assets/images/event/event-5.jpg";
				
				$query = mysqli_query($connection, "INSERT INTO student_events VALUES('','$e_title','$e_date','$e_time','$e_des ','$student_name','$e_status','$e_pic')");
				header('Location: event.php');
				exit;
				
			}
		}
		if(isset($_GET['delete'])){	
			$delete_id = $_GET['delete'];
			mysqli_query($connection,"DELETE FROM student_events WHERE event_id='$delete_id'");
			header('Location: event.php');
			exit;
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
							<div class="col-lg-7">
								<div class="loadMore">
									<div class="central-meta item">
										<nav>
										    <div class="nav nav-tabs" id="nav-tab" role="tablist">
										    	<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personal event</a>
										    	<a class="nav-item nav-link" id="nav-friend-tab" data-toggle="tab" href="#nav-friend" role="tab" aria-controls="nav-friend" aria-selected="false">Friend event</a>
										     	<a class="nav-item nav-link" id="nav-everyone-tab" data-toggle="tab" href="#nav-everyone" role="tab" aria-controls="nav-everyone" aria-selected="false">Public event</a>
  											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<!-- personal event tab -->
  											<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
												<div class="row">
													<?php
														$query1=mysqli_query($connection,"SELECT * FROM student_events WHERE created_by ='$student_name' AND event_status='myself'  ");
														$i=0; 
														while($event_query = mysqli_fetch_array($query1)){
															$event_id = $event_query['event_id'];
															$event_name = $event_query['event_name'];
															$event_date = $event_query['event_date'];
															$event_time = $event_query['event_time'];
															$event_status=$event_query['event_status'];
															$event_description = $event_query['event_description'];
															$event_created=$event_query['created_by'];
															
																
															$i++;		
													?>
														<div class="col-sm-8 col-md-4">
															<div class="card-deck">
														        <!-- set a width on the image otherwise it will expand to full width       -->
														        <img class="card-img-top" src="<?php echo $event_query['event_pic']; ?>" alt="Card image cap" style="width: 260px;height: 200px;">
														        <div class="card-body">
				          											<h5 class="card-title"><label>Event : </label><?php echo $event_name; ?></h5>
																	<h6><label>Date : </label><?php echo $event_date; ?></h6>
																	<h6><label>Time : </label><?php echo $event_time; ?></h6>
																    <p class="card-text"><label>Info : </label><?php echo $event_description; ?></p>
																    <?php
																		if($event_created == $student_name){
																	?>
																	<a href="event.php?delete=<?php echo $event_id; ?>">
																		<button type="button" class="btn btn-danger" name="delete">Delete</button>
																	</a>
																	<?php
																	}?>
				        										</div>
			      											</div>
													    <!-- /.card -->
														</div>
													<?php } ?>
    												<!-- /.col-sm-4 -->
  												</div>
											</div>
											<!-- close personal event tab -->
											<!--friend event tab u created -->
 											<div class="tab-pane fade" id="nav-friend" role="tabpanel" aria-labelledby="nav-friend-tab">
												<div class="row">
													<?php
														$query1=mysqli_query($connection,"SELECT * FROM student_events WHERE created_by ='$student_name' AND event_status='friend'  ");
														$i=0; 
														while($event_query = mysqli_fetch_array($query1)){
															$event_id = $event_query['event_id'];
															$event_name = $event_query['event_name'];
															$event_date = $event_query['event_date'];
															$event_time = $event_query['event_time'];
															$event_status=$event_query['event_status'];
															$event_description = $event_query['event_description'];
															$event_created=$event_query['created_by'];
															
															$i++;		
													?>
														<div class="col-sm-8 col-md-4">
															<div class="card-deck">
														        <!-- set a width on the image otherwise it will expand to full width       -->
														        <img class="card-img-top" src="<?php echo $event_query['event_pic']; ?>" alt="Card image cap" style="width: 260px;height: 200px;">
														        <div class="card-body">
				          											<h5 class="card-title"><label>Event : </label><?php echo $event_name; ?></h5>
																	<h6><label>Date : </label><?php echo $event_date; ?></h6>
																	<h6><label>Time : </label><?php echo $event_time; ?></h6>
																    <p class="card-text"><label>Info : </label><?php echo $event_description; ?></p>
																    <?php
																		if($event_created == $student_name){
																	?>
																	<a href="event.php?delete=<?php echo $event_id; ?>">
																		<button type="button" class="btn btn-danger" name="delete">Delete</button>
																	</a>
																	<?php
																	}?>
				        										</div>
			      											</div>
													    <!-- /.card -->
														</div>
													<?php } ?>
    												<!-- /.col-sm-4 -->
  												</div>
 											</div>
 											<!--close friend event tab u created -->
 											<!--public event tab -->
 											<div class="tab-pane fade" id="nav-everyone" role="tabpanel" aria-labelledby="nav-everyone-tab">
												<div class="row">
													<?php
														$query1=mysqli_query($connection,"SELECT * FROM student_events WHERE event_status='everyone'  ");
														$i=0; 
														while($event_query = mysqli_fetch_array($query1)){
															$event_id = $event_query['event_id'];
															$event_name = $event_query['event_name'];
															$event_date = $event_query['event_date'];
															$event_time = $event_query['event_time'];
															$event_status=$event_query['event_status'];
															$event_description = $event_query['event_description'];
															$event_created=$event_query['created_by'];
															
															$i++;		
													?>
														<div class="col-sm-8 col-md-4">
															<div class="card-deck">
														        <!-- set a width on the image otherwise it will expand to full width       -->
														        <img class="card-img-top" src="<?php echo $event_query['event_pic']; ?>" alt="Card image cap" style="width: 260px;height: 200px;">
														        <div class="card-body">
				          											<h5 class="card-title"><label>Event : </label><?php echo $event_name; ?></h5>
																	<h6><label>Date : </label><?php echo $event_date; ?></h6>
																	<h6><label>Time : </label><?php echo $event_time; ?></h6>
																    <p class="card-text"><label>Info : </label><?php echo $event_description; ?></p>
																    <?php
																		if($event_created == $student_name){
																	?>
																	<a href="event.php?delete=<?php echo $event_id; ?>">
																		<button type="button" class="btn btn-danger" name="delete">Delete</button>
																	</a>
																	<?php
																	}?>
				        										</div>
			      											</div>
													    <!-- /.card -->
														</div>
													<?php } ?>
    												<!-- /.col-sm-4 -->
  												</div>
 											</div>
 											<!-- close public event tab -->
										</div>
									</div><!-- add post new box -->
								</div>
							</div><!-- centerl meta -->
							<div class="col-lg-2">
								<aside class="sidebar static">
									<div class="widget">
									
										
									<!-- Button trigger modal -->
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										  Create Event
										</button>

										<!-- Modal -->
										<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form action="event.php" method="POST">
														<label>Event :  </label> 
															<input type="text" name="event_title" required>
															<br>
														<label>Date : </label>
															<input type="date" name="event_date" required>
															<br>
														<label>Time : </label>
															<input type="time" name="event_time" required>
															<br>
														<label>Event status :  </label> 
															<input type="radio" name="event_radio" value="friend" checked>Friend															
															<input type="radio" name="event_radio" value="everyone">Everyone
															<input type="radio" name="event_radio" value="myself">Myself
															<br>
														<label>Event Info : </label>
														<textarea name="event_description" rows="2" cols="50"> </textarea>
															
															<br>
															<br>
														<input type="submit" name="submit" value="submit">
													</form>
												</div>
										    </div>
										  </div>
										</div>
									</div><!-- friends list sidebar -->
								</aside>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</body>
</html>