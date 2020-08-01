	<?php
		include("includes/header.php");
		if(isset($_GET['view'])) {
			$view_id = $_GET['view'];
			$student_details_query = mysqli_query($connection, "SELECT * FROM group_entry WHERE group_id='$view_id'");
			$student_array = mysqli_fetch_array($student_details_query);
			$view_name = $student_array['group_name'];
			$view_student_name = $student_array['created_by'];

		}
		
		if(isset($_POST['submit'])){
			$post = new Group($connection, $studentLogIn);
			$post->submitGroup($_POST['post-text'], 'none');
			header("Location: group_view.php?view=$view_id");
		}
	?>
	<!-- main section  -->
	<div class="feature-photo">
		<!-- cover image -->
		<figure>
			<img src="<?php echo $student_array['cover_pics']; ?>">
		</figure>
	
		<!-- start of second navigation  -->
		<div class="container-fluid">
			<div class="row merged">
				<!-- div container to wrap profile image s  -->
				<div class="col-lg-2 col-sm-3">
					<!-- profile image   -->
					<div class="user-avatar">
						<figure>
							<img src="<?php echo $student_array['profile_pics']; ?>">
							
						</figure>
					</div>
					<!-- end of profile image  -->
				</div>
				<!-- end of div container for profile image -->
				<!-- div container to wrap the inner navigation   -->
				<div class="col-lg-10 col-sm-9">
					<div class="timeline-info">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<!-- display user name  -->
							<li class="user-name">
								<h5>
								 	<?php echo $view_name; ?>								 		
								</h5>
							</li>
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Timeline</a>
							</li>
							<!-- end of inner navigation  -->
						</ul>
					</div>
				</div>
				<!-- end of div container for inner navigation  -->
			</div>
			<!-- end of row merged   -->
		</div>
		<!-- end of second navigation  -->
	</div>
		<!-- end of main section  -->
	</section>
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
								<!-- shortcut navigation -->
                				<?php include("shortcut.php");?>
							</div><!-- sidebar -->
							<div class="col-lg-9">
								<div class="loadMore">
									<!-- load post if they are freinds -->
									<div class="central-meta item">
										<div class="new-postbox">
											<figure>
												<img src="<?php echo $student_array['profile_pics']; ?>">
											</figure>
											<div class="newpost-input">
												<form action="" method="POST">
													<textarea name="post-text" id="post-text" placeholder="Got something to share !!"rows="2" ></textarea>
													<div class="attachments">
														<ul>
															<li>
																<input type="submit" name="submit" value="submit">
															</li>
														</ul>
													</div>
												</form>
											</div>
										</div>
										<hr>
										<br>
										<?php
											$post = new Group($connection, $studentLogIn);
											$post->loadGroupPosts();
										?>
        							</div>
        							<!-- close central -->
        						</div>
        						<!-- close load more -->	
							</div><!-- centerl meta col-->
						</div>
					</div>	
				</div>
			</div>
		</div>
	</section>
</body>
</html>
