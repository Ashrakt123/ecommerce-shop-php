<?php
//condition?true:false;
session_start();

$pageTitle = 'members';

	if (isset($_SESSION['Username'])) {

   include 'ini.php';

$action= isset($_GET['action'])? $_GET['action']:'manage';

if($action == 'manage'){
	//activate member
	$query ='';
	if(isset($_GET['page'])&& $_GET['page']= 'pending' ){
		$query =" AND RegStatus = 0";
	}
	
	$stm =$con ->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
	$stm ->execute();
	//asighn to variable
	$rows = $stm->fetchAll();
?>
                    <!--manage page -->
            <h1 class="text-center">Manage Page </h1>
			<div class="container">
				<div class="table-responsive"> 
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>UserID</td>
							<td>User Name</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registered Date</td>
							<td>Control</td>

                       </tr>
					   <?php
					   foreach($rows as $row){
                          echo '<tr>';
						  echo '<td>'.$row["UserID"] .'</td>';
                          echo '<td>'.$row["Username"] .'</td>';
						  echo '<td>'.$row["Email"].'</td>';
						  echo '<td>'.$row["Fullname"] .'</td>';
						  echo '<td>'.$row["Date"] .'</td>';
						  echo '<td>'.$row["Fullname"] .'</td>';


						  echo "<td>
						  <a href='members.php?action=edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
						  <a href='members.php?action=delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
						  if($row['RegStatus'] == 0){
							echo "<a href='members.php?action=activate&userid=" . $row['UserID'] . "' class='btn btn-info activate'><i class='fa fa-close'></i> Activate </a>";

						  }
						  echo "</td>";
								echo "</tr>";
					   }
					   ?>
					 
					  
</table>
						
</div>
            <a href="members.php?action=add"  class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
</div> 

   <?php
}
//start add manager
elseif($action == 'add'){
	?>

         <h1 class="text-center">Add New Member</h1>
			<div class="container">
		    <form class="form-horizontal" action="?action=insert" method="post">

                <!--username field-->
	           <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Username</label>
				  <div class="col-sm-10">
				   <input type="text"  name="username" class="form-control" autocomplete="off" required ='required'  placeholder="Username To Login Into Shop"/>
				  </div>
				</div>
                <!--username field-->

                <!--password-->
                <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Password</label>
				  <div class="col-sm-10">
                  <input type="password" name="password" class="password form-control" required ='required' autocomplete="new-password" placeholder="Password Must Be Hard & Complex"/>
				  <i class="show-pass fa fa-eye fa-2x"></i>
				  </div>
				</div>
                 <!--password-->

                  <!--email-->
                <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Email</label>
				  <div class="col-sm-10">
				   <input type="email"  name="email" required ='required'  class="form-control" placeholder="Enter Your Email"/>
				  </div>
				</div>
                <!--email-->

                  <!--fullname-->
                  <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Full Name</label>
				  <div class="col-sm-10">
				   <input type="text"  name="fullname" class="form-control" placeholder="Enter Your Full Name"/>
				  </div>
				</div>
                <!--fullname-->

                <!-- Start Submit Field -->
				<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label"></label>

						<div class="col-sm-offset-2 ">
							<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
						</div>
					</div>
				<!-- End Submit Field -->
            </form>
                </div>
			
<?php
}
   //end add manager

   // start insert page
 elseif($action == 'insert'){
  // echo $_POST['username'].$_POST['password'].$_POST['email'].$_POST['fullname'];
	
	if($_SERVER['REQUEST_METHOD']== 'POST'){
		echo "<h1 class='text-center'>Insert Member</h1>";
		echo "<div class='container'>";
	 
	$username =$_POST['username'];
	$pass     =$_POST['password'];
	$sha1pass =sha1($pass);
	$email    =$_POST['email'];
	$fullname =$_POST['fullname'];

	if(strlen($username)< 3){
		$formerrors[]= 'the name must <strong> bigger than </strong> 3char';

	}
	 if(strlen($username)>20) {
		$formerrors[]= 'the name must <strong> less </strong> than 20';

	}
	
	if(empty($pass)){
		$formerrors[]= 'pass cant be empty';
	}
	if(empty($email)){
		$formerrors[]= ' user <strong> empty </strong>';
	}	
	 if(empty($fullname)){
		$formerrors[]= 'fullname cant be empty';
	}
}
 
//validate the form
	$formerrors=array();
	foreach($formerrors as $error){
		echo '<div class="alert alert-danger">'.$error .'</div></br>';
   }
	
	if(empty($formerrors)){
		//check if user exist in DB
	   $check=  checkItem("Username" ,"users" ,$username);
		 if($check ==1){
			echo "<div class='container'>";
			$msg='<div class="alert alert-success">sorry this user is existed</div>' ;
			redirectHome($msg,'back' ,4);
			echo "</div>"; 

		

		 }else{
		    //استعلام
		       $stmt=$con->prepare("INSERT INTO users
		                                 (Username ,Pass ,Email ,Fullname ,RegStatus,Date)
										 VALUES (:vname , :vpass , :vemail , :vfullname , 1 ,now() )");
            //تنفيذ للقيم اللى جايه من الفورم
		       $stmt ->execute(array(
			      'vname' =>$username ,
			      'vpass' =>$sha1pass ,
			      'vemail'=>$email ,
		          'vfullname'=>$fullname

		         ));
				 echo "<div class='container'>";
				 $msg='<div class="alert alert-success">' .$stmt->rowcount().'record inserted</div>' ;
				 redirectHome($msg,'back' ,4);
				 echo "</div>"; 

				}
	 }else{
		$msg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

		redirectHome($msg,'back' ,4);
	}
       echo '</div>';
 



 //end insert page

}elseif($action == 'edit'){
	$userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']):0;
		echo $userid;

		$stmt = $con->prepare("SELECT * FROM  users WHERE  UserID = ? LIMIT 1");
        $stmt ->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
		if($count  >0){
    ?>
			<h1 class="text-center">Update Member</h1>
			<div class="container">
		    <form class="form-horizontal" action="?action=update" method="post">
			<input type="hidden" value=<?php echo $userid ?>  name="id" />

                <!--username field-->
	           <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Username</label>
				  <div class="col-sm-10">
				   <input type="text" value="<?php echo $row['Username']?>"  name="username" class="form-control" autocomplete="off" required ='required'  placeholder="Username To Login Into Shop"/>
				  </div>
				</div>
                <!--username field-->

                <!--password-->
                <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Password</label>
				  <div class="col-sm-10">
				  <input type="hidden" name="oldpassword" value="<?php echo $row['Pass']?>"/>
                  <input type="password" name="newpassword" class="form-control" required ='required' autocomplete="new-password" placeholder="Password Must Be Hard & Complex"/>
				  </div>
				</div>
                 <!--password-->

                  <!--email-->
                <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Email</label>
				  <div class="col-sm-10">
				   <input type="email" value="<?php echo $row['Email']?>" name="email" required ='required'  class="form-control"/>
				  </div>
				</div>
                <!--email-->

                  <!--fullname-->
                  <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Full Name</label>
				  <div class="col-sm-10">
				   <input type="text" value="<?php echo $row['Fullname']?>" name="fullname" class="form-control"/>
				  </div>
				</div>
                <!--fullname-->

                <!-- Start Submit Field -->
				<div class="form-group form-group-lg">
				<label class="col-sm-2 control-label"></label>

						<div class="col-sm-offset-2 ">
							<input type="submit" value="EditMember" class="btn btn-primary btn-lg" />
						</div>
					</div>
				<!-- End Submit Field -->
            </form>
                </div>
			
<?php
    }else{
		echo "<div class='container'>";
		$msg = '<div class="alert alert-danger"> there is no such id</div>' ;
	    redirectHome($msg );
		echo "</div>";
}


     //update
       }elseif($action == 'update'){
      	echo "<h1 class='text-center'>Update Member</h1>";
     	echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']== 'POST'){
        $id  =$_POST['id'];
		$username=$_POST['username'];
		$email   =$_POST['email'];
		$fullname=$_POST['fullname'];
        $pass= empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);
		  
		//validate the form
		$formerrors=array();
		if(empty($username)){
			$formerrors[]= '<div class="alert alert-danger"> user <strong> empty </strong></div>';
		}
		if(strlen($username)< 3){
			$formerrors[]= '<div class="alert alert-danger"> the name must <strong> bigger than </strong> 3char</div>';

		}
		if(strlen($username)>20) {
			$formerrors[]= '<div class="alert alert-danger">the name must <strong> less </strong> than 20</div>';

		}
        if(empty($email)){
			$formerrors[]= '<div class="alert alert-danger">email empty</div>';
		}
		if(empty($fullname)){
			$formerrors[]= '<div class="alert alert-danger">fullname empty</div>';
		}
		foreach($formerrors as $error){
           echo $error .'</br>';
		}
		//echo  $username. $email .$fullname ;

		//check if there is no errors proceed the update operation 
		if(empty($formerrors)){
           
			$stmt = $con->prepare("UPDATE users SET Username= ? ,Email =? ,Fullname =? ,Pass =? WHERE UserID =?");
            $stmt ->execute(array($username ,$email ,$fullname,$pass ,$id));
            $msg= '<div class="alert alert-success">' .$stmt->rowcount().'row updated</div>' ;
			redirectHome($msg,'back' ,4);

		                     }
	     }else{
		echo "<div class='container'>";
		$msg = '<div class="alert alert-danger">sorry you cannt browse this page directly</div>' ;
	    redirectHome($msg );
		echo "</div>";
	}
		echo '</div>';

       // delete member page
    }elseif($action == 'delete'){
	echo "<h1 class='text-center'>Delete Member</h1>";
	echo "<div class='container'>";
	$userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']):0;
    $stmt = $con->prepare("SELECT * FROM  users WHERE  UserID = ? LIMIT 1");
	$check =checkItem("userid", "users",$userid );
	
	/*
	checkitem function instead of this
	$stmt ->execute(array($userid));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();*/
	    if($check  >0){
	     	$stmt=$con->prepare("DELETE FROM users WHERE UserID = :userid");

		    $stmt->bindparam(':userid' ,$userid);
		    $stmt->execute();
			$msg= '<div class="alert alert-success">'.$stmt->rowcount().'row deleted</div>' ;
			redirectHome($msg,'back' ,4);
        }else{
	      echo "<div class='container'>";
		  $msg = '<div class="alert alert-danger">this id no exist</div>' ;
	      redirectHome($msg );
		  echo "</div>";
             }
			 echo '</div>';
}    //start activate page
elseif($action =='activate'){
	echo "<h1 class='text-center'>Activate Member</h1>";
	echo "<div class='container'>";
	$userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']):0;
    $check =checkItem("userid", "users",$userid );
	    if($check  >0){
            $stmt = $con->prepare("UPDATE users SET RegStatus =1 WHERE UserID=?");
		    $stmt->execute(array($userid));
			$msg= '<div class="alert alert-success">'.$stmt->rowcount().'row activated</div>' ;
			redirectHome($msg,'back' ,4);
        }else{
	      echo "<div class='container'>";
		  $msg = '<div class="alert alert-danger">this id no exist</div>' ;
	      redirectHome($msg );
		  echo "</div>";
             }
			 echo '</div>';}

// end delete page
include $tmp.'footer.php'; 
} else {

header('Location: index.php');

exit();
}

ob_end_flush(); // Release The Output

?>

