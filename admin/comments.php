<?php
//condition?true:false;
session_start();

$pageTitle = 'comments';

	if (isset($_SESSION['Username'])) {

   include 'ini.php';

$action= isset($_GET['action'])? $_GET['action']:'manage';

if($action == 'manage'){
    $stm =$con ->prepare("SELECT comments.* , items.Name ,users.Username 
                          FROM comments 
                          INNER JOIN users ON 
                          users.UserID = comments.UserComID
                          INNER JOIN items ON
                          items .ItemID = comments.ItemID ORDER BY CID DESC");
	$stm ->execute();
	//asighn to variable
	$rows = $stm->fetchAll();
    if(!empty($rows)){
?>
                    <!--manage page -->
            <h1 class="text-center">Manage Page </h1>
			<div class="container">
				<div class="table-responsive"> 
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Date</td>
							<td>User Name</td>
							<td>Item Name</td>
							<td>Control</td>

                       </tr>
					   <?php
					   foreach($rows as $row){
                          echo '<tr>';
						  echo '<td>'.$row["CID"] .'</td>';
                          echo '<td>'.$row["Comment"] .'</td>';
						  echo '<td>'.$row["Date"].'</td>';
						  echo '<td>'.$row["Username"] .'</td>';
						  echo '<td>'.$row["Name"] .'</td>';


						  echo "<td>
						  <a href='comments.php?action=edit&cid=" . $row['CID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
						  <a href='comments.php?action=delete&cid=" . $row['CID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
						  if($row['Status'] == 0){
							echo "<a href='comments.php?action=approve&cid=" . $row['CID'] . "' class='btn btn-info activate'><i class='fa fa-close'></i> Approve </a>";

						  }
						  echo "</td>";
								echo "</tr>";
					   }
					   ?>
					 
					  
</table>


   <?php
   } else{
                echo "<div class='container'>";
                echo '<div class="alert alert-info"> there\'s no comment to show</div>' ;
                echo "</div>";
               

          }

//start edit comment


}elseif($action == 'edit'){
	    $comid= isset($_GET['cid']) && is_numeric($_GET['cid'])? intval($_GET['cid']):0;
		$stmt = $con->prepare("SELECT * FROM comments WHERE  CID = ? ");
        $stmt ->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
		if($count  >0){
    ?>
			<h1 class="text-center">Update Comment</h1>
			<div class="container">

		    <form class="form-horizontal" action="?action=update" method="post">
			<input type="hidden" value=<?php echo $comid ?>  name="id" />

                <!--comment field-->
	           <div class="row form-group form-group-lg">
			    <label class="col-sm-2 control-label">Comment</label>
				  <div class="col-sm-10">
				   <textarea name="comment" class="form-control"><?php echo $row['Comment']?></textarea>
				  </div>
				</div>
                <!--comment field-->

                  <!-- Start Submit Field -->
                  <div class="form-group form-group-lg">   
                    <div class="col-sm-offset-2 col-sm-10 ">
                     <input type="submit" value="save" class="btn btn-primary btn-sm" />
                           </div>
                       </div>
                   <!-- End Submit Field -->
            </form>
                </div>
			
<?php

$stm =$con ->prepare("SELECT comments.* ,users.Username FROM comments INNER JOIN users
                      ON users.UserID = comments.UserComID WHERE CID =?");

$stm ->execute(array($comid));
//asighn to variable
$rows = $stm->fetchAll();
?>
<!--manage page -->
<h1 class="text-center">Manage [<?php echo $row['Comment']; ?>] Page </h1>
<div class="table-responsive"> 
<table class="main-table text-center table table-bordered">
<tr>
  <td>Comment</td>
  <td>Date</td>
  <td>User Name</td>
  <td>Control</td>

</tr>
<?php
foreach($rows as $row){
echo '<tr>';
echo '<td>'.$row["Comment"] .'</td>';
echo '<td>'.$row["Date"].'</td>';
echo '<td>'.$row["Username"] .'</td>';
echo "<td>
<a href='comments.php?action=edit&cid=" . $row['CID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
<a href='comments.php?action=delete&cid=" . $row['CID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
if($row['Status'] == 0){
  echo "<a href='comments.php?action=approve&cid=" . $row['CID'] . "' class='btn btn-info activate'><i class='fa fa-close'></i> Approve </a>";

}
echo "</td>";
      echo "</tr>";
}
?>


</table>
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
      	echo "<h1 class='text-center'>Update Comment</h1>";
     	echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']== 'POST'){

        $id  =$_POST['id'];
		$name=$_POST['comment'];

			$stmt = $con->prepare("UPDATE comments SET Comment= ? WHERE CID =?");
            $stmt ->execute(array( $name ,$id));
            $msg= '<div class="alert alert-success">' .$stmt->rowcount().'row updated</div>' ;
			redirectHome($msg,'back' ,4);

		                     
	     }else{
		echo "<div class='container'>";
		$msg = '<div class="alert alert-danger">sorry you cannt browse this page directly</div>' ;
	    redirectHome($msg );
		echo "</div>";
	}
		echo '</div>';

       // delete member page
    }elseif($action == 'delete'){
	echo "<h1 class='text-center'>Delete Comment</h1>";
	echo "<div class='container'>";
	$comid= isset($_GET['cid']) && is_numeric($_GET['cid'])? intval($_GET['cid']):0;
	$stmt = $con->prepare("SELECT * FROM comments WHERE  CID = ? ");
	$check =checkItem("CID", "comments", $comid );

	    if($check  >0){
	     	$stmt=$con->prepare("DELETE FROM comments WHERE CID = :com");

		    $stmt->bindparam(':com' ,$comid);
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
elseif($action =='approve'){
	echo "<h1 class='text-center'>Approve Comment</h1>";
	echo "<div class='container'>";
	$comid= isset($_GET['cid']) && is_numeric($_GET['cid'])? intval($_GET['cid']):0;
	$check =checkItem("CID", "comments", $comid );
	    if($check  >0){
            $stmt = $con->prepare("UPDATE comments SET Status =1 WHERE CID=?");
		    $stmt->execute(array($comid));
			$msg= '<div class="alert alert-success">'.$stmt->rowcount().'row approved</div>' ;
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

