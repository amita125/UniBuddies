	<?php
		include("includes/header.php");
		if (isset($_SESSION['student_name'])){
			$student_name=$_SESSION['student_name'];
		}

		if(isset($_POST["submit"])) {
			$target_dir = "assets/images/users/". uniqid() ;
			$target_file = $target_dir. basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
	   		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	   		if($check !== false) {
	        	$uploadOk = 1;
	        } else {
					        	
	        	$uploadOk = 0;
	    	}
	    	// Check if file already exists
			if (file_exists($target_file)) {
			
	    		$uploadOk = 0;
			}
			// Check file size

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" &&$imageFileType != "jpeg"&& $imageFileType != "JPEG" &&  $imageFileType != "GIF" && $imageFileType != "gif" ) {
				
	   			$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				echo '<script language="javascript">';
				echo 'alert("Sorry, your file was not uploaded.")';
				echo '</script>';
	    		
				// if everything is ok, try to upload file
			} else {
	    		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$result_path= $target_dir.  basename($_FILES["fileToUpload"]["name"]);
				$insert_pic_query = mysqli_query($connection, "INSERT INTO images VALUES('','$result_path','$student_name')");
	    		} else {
					echo '<script language="javascript">';
					echo 'alert("Sorry, there was an error uploading your file.")';
					echo '</script>';
					
	    		}
			}
		}
		if(isset($_GET['delete'])){	
			$delete_id = $_GET['delete'];
			mysqli_query($connection,"DELETE FROM images WHERE id='$delete_id'");
			header('Location: gallery.php');
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
										<div class="row">
											<?php
												$query1=mysqli_query($connection,"SELECT * FROM images WHERE image_added ='$student_name' ");
												$i=0; 
												while($gallery_query = mysqli_fetch_array($query1)){
													$gallery_id = $gallery_query['id'];
													$gallery_image = $gallery_query['image'];
													$gallery_name = $gallery_query['image_added'];
													$i++;
											?>
											<div class = "col-sm-6 col-md-3">
												<div class = "thumbnail">
													<a href="<?php echo $gallery_image; ?>" target="_blank">
														<img src="<?php echo $gallery_image;?>" style="height:150px;width:200px;">
													</a>
													<a href="gallery.php?delete=<?php echo $gallery_id; ?>">
														<button type="button" class="btn btn-danger" name="delete">Delete</button>
													</a>
												</div>
											</div>
											<?php } ?>
  										</div>
  									<!-- /.row -->
									</div><!-- add post new box -->
								</div>
							</div><!-- centerl meta -->
							<div class="col-lg-2">
								
								<aside class="sidebar static">
									<div class="widget">
									
										
									<!-- Button trigger modal -->
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										 Upload Picture
										</button>

										<!-- Modal -->
										<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Upload Picture</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form class="gallery_form" action="gallery.php" method="POST" enctype="multipart/form-data">
											<input type="file" name="fileToUpload" id="fileToUpload"/>
											<input type="submit" value="Upload Image" name="submit">
										
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