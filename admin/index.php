	<?php
		include("admin_header.php");

	?>
		<div class="gap1 gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">Manage Content </h4>
										<ul class="naves">
											
											<li>
												<a href="index.php?view_users" title="">Users</a>
											</li>
											<li>
												<a href="index.php?view_posts" title="">Post</a>
											</li>
											<li>
												<a href="index.php?view_posts_comment" title="">Comment</a>
											</li>
											<li>
												<a href="index.php?view_events" title="">Events</a>
											</li>
											<li>
												<a href="index.php?view_group" title="">Groups</a>
											</li>
											<li>
												<a href="index.php?view_group_post" title="">Groups Posts</a>
											</li>
											<li>
												<a href="index.php?view_group_comment" title="">Groups Comment</a>
											</li>
											<li>
												<a href="index.php?view_forum" title="">Forum Discussion</a>
											</li>
											<li>
												<a href="index.php?view_forum_replies" title="">Forum Replies</a>
											</li>
											<li>
												<a href="index.php?view_comment_report" title="">Comment Report</a>
											</li>
											<li>
												<a href="index.php?view_post_report" title="">Post Report</a>
											</li>
											<li>
												<a href="index.php?view_forum_report" title="">Forum Report</a>
											</li>
											<li>
												<a href="index.php?view_replies_report" title="">Forum replies Report</a>
											</li>
											
										</ul>
									</div><!-- Shortcuts -->
								</aside>
							</div><!-- sidebar -->
							<div class="col-lg-9">
								<div class="loadMore">
									<div class="central-meta item">
										<?php 
										
											if(isset($_GET['view_users'])){
											include("includes/view_users.php");
											}
											if(isset($_GET['view_posts'])){
											include("includes/view_posts.php");
											}
											if(isset($_GET['view_posts_comment'])){
											include("includes/view_posts_comment.php");
											}
											if(isset($_GET['view_events'])){
											include("includes/view_events.php");
											}
											if(isset($_GET['view_group'])){
											include("includes/view_group.php");
											}
											if(isset($_GET['view_group_post'])){
											include("includes/view_group_post.php");
											}
											if(isset($_GET['view_group_comment'])){
											include("includes/view_group_comment.php");
											}
											if(isset($_GET['view_forum'])){
											include("includes/view_forum.php");
											}
											if(isset($_GET['view_forum_replies'])){
											include("includes/view_forum_replies.php");
											}
											if(isset($_GET['view_comment_report'])){
											include("includes/view_comment_report.php");
											}
											if(isset($_GET['view_post_report'])){
											include("includes/view_post_report.php");
											}
											if(isset($_GET['view_forum_report'])){
											include("includes/view_forum_report.php");
											}
											if(isset($_GET['view_replies_report'])){
											include("includes/view_replies_report.php");
											}
											?>
									</div>
								</div>
							</div><!-- centerl meta -->
							

							
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</body>
</html>