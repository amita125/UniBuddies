	<?php

		include("includes/header.php");

		if (isset($_SESSION['student_name'])){
			$student_name=$_SESSION['student_name'];
			
			if(isset($_POST['submit'])){
				$student_name=$_SESSION['student_name'];
				$group_name = strip_tags($_POST['group_name']); //Remove html tags
				$group_name = str_replace(' ', '', $group_name); //remove spaces
				$group_name = ucfirst(strtolower($group_name)); //Uppercase first letter
				$group_status = $_POST['Group_radio'];
				$group_profile_pic = "assets/images/backgrounds/1.jpg";
				$group_cover_pic = "assets/images/backgrounds/2.jpg";
				$date = date("Y-m-d");
				$query = mysqli_query($connection, "INSERT INTO group_entry VALUES ('', '$group_name', '$student_name','$date','$group_profile_pic','$group_cover_pic','$group_status')");
				
				header('Location: group.php');
				exit;
				
			}
		}
		if(isset($_GET['delete'])){	
			$delete_id = $_GET['delete'];
			mysqli_query($connection,"DELETE FROM group_entry WHERE group_id='$delete_id'");
			header('Location: group.php');
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
												<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Your group</a>
												<a class="nav-item nav-link" id="nav-group-tab" data-toggle="tab" href="#nav-group" role="tab" aria-controls="nav-group" aria-selected="false">Public Group</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
												<div class="row">
													<?php
														$query1=mysqli_query($connection,"SELECT * FROM group_entry WHERE created_by ='$student_name'");
														$i=0; 
														while($group_query = mysqli_fetch_array($query1)){
															$group_id = $group_query['group_id'];
															$group_name = $group_query['group_name'];
															$group_created=$group_query['created_by'];
															$i++;		
													?>
														<div class="col-sm-8 col-md-4">
															<div class="card-deck">
														    <!-- set a width on the image otherwise it will expand to full width       -->
														        <img class="card-img-top" src="<?php echo $group_query['profile_pics'];?>" alt="Card image cap" style="width: 260px;height: 200px;">
															    <div class="card-body">
												        			<h5 class="card-title"><label>Group: </label><?php echo $group_name; ?></h5>
																	<h6><label>Created By : </label><?php echo $group_created; ?></h6>
																	<?php
																		if($group_created == $student_name){
																	?>
																		<a href="group.php?delete=<?php echo $group_id; ?>">
																			<button type="button" class="btn btn-danger" name="delete">Delete</button>
																		</a>
																	<?php
																	}?>
																	<a href="group_view.php?view=<?php echo $group_id; ?>">
																		<button type="button" class="btn btn-success" name="view">View</button>
																	</a>
												        		</div>
											      			</div>
															<!-- /.card -->
														</div>
													<?php } ?>
  												</div>
											</div>
 											<div class="tab-pane fade" id="nav-group" role="tabpanel" aria-labelledby="nav-group-tab">
  												<div class="row">
													<?php
														$query1=mysqli_query($connection,"SELECT * FROM group_entry WHERE created_by !='$student_name' AND group_status='everyone'");
														$i=0; 
														while($group_query = mysqli_fetch_array($query1)){
															$group_id = $group_query['group_id'];
															$group_name = $group_query['group_name'];
															$group_created=$group_query['created_by'];
															$i++;		
													?>
														<div class="col-sm-8 col-md-4">
															<div class="card-deck">
														    <!-- set a width on the image otherwise it will expand to full width       -->
														        <img class="card-img-top" src="assets/images/events/event-2.jpg" alt="Card image cap" style="width: 260px;height: 200px;">
															    <div class="card-body">
												        			<h5 class="card-title"><label>Group: </label><?php echo $group_name; ?></h5>
																	<h6><label>Created By: </label><?php echo $group_created; ?></h6>
																	<?php
																		if($group_created == $student_name){
																	?>
																		<a href="group.php?delete=<?php echo $group_id; ?>">
																			<button type="button" class="btn btn-danger" name="delete">Delete</button>
																		</a>
																	<?php
																	}?>
																	<a href="group_view.php?view=<?php echo $group_id; ?>">
																		<button type="button" class="btn btn-success" name="view">view</button>
																	</a>
												        		</div>
											      			</div>
															<!-- /.card -->
														</div>
													<?php } ?>
  												</div>
 											</div>
										</div>
									</div><!-- add post new box -->
								</div>
							</div><!-- centerl meta -->
							<div class="col-lg-2">
								<aside class="sidebar static">
									<div class="widget">
									<!-- Button trigger modal -->
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										  Create group
										</button>
										<!-- Modal -->
										<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Create group</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form action="group.php" method="POST">
														<label>Group name :  </label> 
															<input type="text" name="group_name" required>
															<br>
															<label>Group status :  </label> 
															<input type="radio" name="Group_radio" value="friend" checked>Friend															
															<input type="radio" name="Group_radio" value="everyone">Everyone
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