<?php 
//to resolve problem of header already sent
ob_start(); //start output buffering(store all output in ram without header)
session_start();

if (isset($_SESSION['Username'])) {

   $pageTitle = 'Dashboard';

   include 'ini.php';

   /* Start Dashboard Page */

   $numUsers = 6; // Number Of Latest Users

   $latestUsers =  latestItems("*", "users", "UserID", $numUsers); // Latest Users Array

   $numItems = 6; // Number Of Latest Items

   $latestItems =  latestItems("*", 'items' ,'ItemID', $numItems); // Latest Items Array

   $numComments = 6 ;


   ?>
		<div class="home-stats">
			<div class="container text-center">
				<h1>Dashboard</h1>
				<div class="row">

					<div class="col-md-3">
						<div class="stat members">
							<i class="fa fa-users"></i>
							<div class="info">
								Total Members
								<span>
									<a href="members.php"><?php echo countItems('UserID', 'users') ?></a>
								</span>
							</div>
						</div>
					</div>


					<div class="col-md-3">
						<div class="stat pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								Pending Members
								<span>
									<a href="members.php?do=Manage&page=Pending">
										<?php echo checkItem("RegStatus", "users", 0) ?>
									</a>
								</span>
							</div>
						</div>
					</div>


					<div class="col-md-3">
						<div class="stat items">
							<i class="fa fa-tag"></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php"><?php echo countItems('ItemID', 'items') ?></a>
								</span>
							</div>
						</div>
					</div>


					<div class="col-md-3">
						<div class="stat comments">
							<i class="fa fa-comments"></i>
							<div class="info">
								Total Comments
								<span>
									<a href="comments.php"><?php echo countItems('ItemID', 'items') ?></a>
								</span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>






		<div class="latest">
			<div class="container">
				<div class="row">

				   <div class="col-sm-6 line">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> 
								Latest <?php echo $numUsers ?> Registerd Users 
								 <span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
								 </span>
							</div>
						<div class="panel-body">
								<ul class="list-unstyled latest-users">
								<?php
									if (! empty($latestUsers)) {
										foreach ($latestUsers as $user) {
											echo '<li>';
												echo $user['Username'];
												echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
														if ($user['RegStatus'] == 0) {
															echo "<a 
																	href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
																	class='btn btn-info pull-right activate'>
																	<i class='fa fa-check'></i> Activate</a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									} else {
										echo 'There\'s No Members To Show';
									}
								?>
								</ul>
						</div>
						</div>
					</div>


					<div class="col-sm-6 line">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest <?php echo $numItems ?> Items 
								 <span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							     </span>
							</div>
						<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php


										if (! empty($latestItems)) {
											foreach ($latestItems as $item) {
												echo '<li>';
												echo $item['Name'];
												echo '<a href="items.php?action=edit&itemid=' . $item['ItemID'] . '">';
												echo '<span class="btn btn-success pull-right">';
												echo '<i class="fa fa-edit"></i> Edit';
													if ($item['Approve'] == 0) {
												echo "<a href='items.php?action=approve&itemid=" . $item['ItemID'] . "'class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Approve</a>";
														                       }
												echo '</span>';
												echo '</a>';
												echo '</li>';
                                                                            }
										}else {
											    echo 'There\'s No Items To Show';
										      }
									?>
								</ul>
						</div>
						</div>
					</div>


				<!-- Start Latest Comments -->
					<div class="col-sm-6 line">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i>Latest <?php echo $numComments ?> Comments 
								  <span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							      </span>
							</div>

						<div class="panel-body">
						<ul class="list-unstyled latest-users">

						  <?php
						  $stm =$con ->prepare("SELECT comments.* , items.Name ,users.Username 
                          FROM comments 
                          INNER JOIN users ON 
                          users.UserID = comments.UserComID
                          INNER JOIN items ON
                          items .ItemID = comments.ItemID ORDER BY CID DESC LIMIT $numComments");
	                      $stm ->execute();
	                      $rows = $stm->fetchAll();
						  if(!empty($rows)){
						   foreach($rows as $row){
							echo '<div class="comment-box">';
							/*echo '<span class="member-n">
								<a href="members.php?action=edit&userid=' . $row['UserID'] . '">
									' . $row['Member'] . '</a></span>';*/
							echo '<p class="member-c">';
							echo "<span class='memberN' >". $row['Username']. '</span>';
							echo "<p class='memberC' >".$row['Comment']. '</p>';

						    echo '</div>';
						                         } 
						}else {
							echo 'There\'s No Comments To Show';
						}
	                     
								?>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<!-- End Latest Comments -->
			</div>
		</div>

		<?php

		/* End Dashboard Page */

      include $tmp.'footer.php'; 

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>
