<?php 
session_start();

if(isset($_SESSION['Username'])){
  $pageTitle = 'dashbord';
  include 'ini.php';
   


 //start dashbord page
 ?>
<div class="container home-stats text-center">
  <h1>Dashbord</h1>
  <div class="row">

  <div class="col-md-3">
     <div class="stat members"> total members <span><a href="members.php"><?php echo countItems('UserID', 'users'); ?> </a></span></div>
  </div>

  <div class="col-md-3">
     <div class="stat pending"> pending members <span><a href="members.php?action=manage&&page=pending"><?php echo checkItem('RegStatus' , 'users', 0); ?> </a></span></div>
  </div>

  <div class="col-md-3">
     <div class="stat items"> total items <span>100</span></div>
  </div>

  <div class="col-md-3">
     <div class="stat comments"> total commnts <span>300</span></div>
  </div>
</div>
</div>


<div class="latest">
<div class="container latest">
  <div class="row">
  <div class="col-sm-6">
						<div class="card"><?php $latesusers =5 ?>
							<div class="card-header">
        <i class="fa fa-users"></i>latest <?php echo $latesusers;?>registered users</div>
     </div>
     <div class="card-body">
        <?php
     $latestItems =latestItems("Username" , "users" ,'UserID', $latesusers);
   foreach( $latestItems as $items){
     echo $items["Username"].'<br>';
   }
   ?>
     </div>
    </div>
   </div>

   <div class="col-sm-6">
						<div class="card">total 
							<div class="card-header">
        <i class="fa fa-tag"></i>latest items</div>
     </div>
     <div class="card-body">test</div>
    </div>
   </div>
  </div>
 </div>


 <?php
 //start dashbord page

  
  include $tmp.'footer.php'; 
}else{
    header('Location:index.php');

}