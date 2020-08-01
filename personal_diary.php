	<?php

		include("includes/header.php");

		if (isset($_SESSION['student_name'])){

			$student_name=$_SESSION['student_name'];
			
			if(isset($_POST['submit'])){
				$diary_mood = $_POST['optradio'];
				$diary_entry = strip_tags($_POST['diary_entry']);
				
				$date = date("Y-m-d H:i:s");
				
				$query = mysqli_query($connection, "INSERT INTO student_diary VALUES ('', '$diary_mood', '$diary_entry','$student_name','$date')");
				
				header('Location: personal_diary.php');
				exit;
					
			}
			
		}
		if(isset($_GET['delete'])){	
			$delete_id = $_GET['delete'];
			mysqli_query($connection,"DELETE FROM student_diary WHERE diary_id='$delete_id'");
			
			$link = '#nav-tab a[href="#nav-diary"]';
  echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";
		}
	?>
	<style>

input[type="radio"] {
    display: none;
}
label:hover {
  background-color: pink;
}
label {
    display: inline-block;
    margin-bottom: .5rem;
    margin: 0 10px 0 10px;
}
textarea {
    width: 750px;
    height: 350px;
    border-radius: 15px;
    font-size: 16px;
    font-style: bold;
    border-color: #df0ca491;
}
input[type="submit"] {
    background-color: #e188df;
    border-radius: 50px;
    width: 100px;
    height: 50px;
	float:right;
}
	
</style>
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
										    	<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Diary Entry</a>
										    	<a class="nav-item nav-link" id="nav-diary-tab" data-toggle="tab" href="#nav-diary" role="tab" aria-controls="nav-diary" aria-selected="false">View Entry</a>
  											</div>
										</nav>
										
										<div class="tab-content" id="nav-tabContent">
											<!-- personal  -->
  											<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
											<br>
												<h3>Your feeling today !!! </h3>
													<form action="personal_diary.php" method="POST">
														<br><br>

														<label class="radio-inline">
															<input type="radio" name="optradio" value="happy" checked><i class="far fa-laugh-squint fa-3x" ></i>
														</label>

														<label class="radio-inline">
															<input type="radio" name="optradio" value="sad"><i class="far fa-frown-open fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="cry"> <i class="far fa-sad-cry fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="tired"> <i class="far fa-tired fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="surprise"> <i class="far fa-surprise fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="blank"> <i class="far fa-meh-blank fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="loved"> <i class="far fa-grin-hearts fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="ok"> <i class="far fa-grimace fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="angry"><i class="far fa-angry fa-3x"></i>
														</label>
														<label class="radio-inline">
															<input type="radio" name="optradio" value="dizzy"> <i class="far fa-dizzy fa-3x"></i>
														</label>

														<br><br><br>

														<textarea name="diary_entry" rows="4" cols="50"  placeholder="Please entry your journal for today ????"></textarea>
														<br><br>
														<input type="submit" name="submit" value="Save">

													</form>
											</div>
											
 											<div class="tab-pane fade" id="nav-diary" role="tabpanel" aria-labelledby="nav-diary-tab">
												
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Your Feeling</th>
      <th scope="col">Entry</th>
      <th scope="col">Date and Time</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        $query1 = mysqli_query($connection, "SELECT * FROM student_diary WHERE created_by = '$student_name' ORDER BY diary_id DESC");
        $i=0;
         while($diary_query = mysqli_fetch_array($query1)){
                    $diary_id = $diary_query['diary_id'];
                    $diary_mood = $diary_query['mood'];
                     $diary_entry = $diary_query['diary_entry'];
                    $diary_created=$diary_query['created_by'];
                     $diary_date = $diary_query['date'];
                    $i++;          
    ?>
    <tr>
     
      <td><?php echo $diary_mood;?></td>
      <td><?php echo $diary_entry;?></td>
      <td><?php echo $diary_date;?></td>
      <td><a href="personal_diary.php?delete=<?php echo $diary_id; ?>">Delete </a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
 											</div>
 											
										</div>
									</div><!-- add post new box -->
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