<?php
	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = '';

	if (isset($_SESSION['Username'])) {

		include 'ini.php';

		$action = isset($_GET['action']) ? $_GET['action'] : 'manage';

 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////


            if($action == 'manage'){
               
                $stm =$con ->prepare("SELECT items .* ,
                                             categories.Name AS CatName ,
                                             users.Username  
                                      FROM items 
                                      INNER JOIN categories ON categories.ID = items.CatID
                                      INNER JOIN users ON users.UserID = items.MemberID;");
                $stm ->execute();
                //asighn to variable
                $rows = $stm->fetchAll();
            ?>
                                <!--manage page -->
                        <h1 class="text-center">Manage Page </h1>

                        <div class="container">
                        <?php if(!empty($rows)){ ?>

                            <div class="table-responsive"> 
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Description</td>
                                        <td>Price</td>
                                        <td>Country</td>
                                        <td>Member</td>
                                        <td>category</td>
                                        <td>Date</td>
                                        <td>Control</td>
                                    </tr>

            <?php                  
                                   foreach($rows as $row){
                                      echo '<tr>';
                                      echo '<td>'.$row["ItemID"] .'</td>';
                                      echo '<td>'.$row["Name"] .'</td>';
                                      echo '<td>'.$row["Description"].'</td>';
                                      echo '<td>'.$row["Price"] .'</td>';
                                      echo '<td>'.$row["CountryMade"] .'</td>';
                                      echo '<td>'.$row["Username"] .'</td>';
                                      echo '<td>'.$row["CatName"] .'</td>';
                                      echo '<td>'.$row["Date"] .'</td>';

                                      echo "<td>
                                       <a href='items.php?action=edit&itemid=" . $row['ItemID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                       <a href='items.php?action=delete&itemid=" . $row['ItemID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                       if($row['Approve'] == 0){
                                        echo "<a href='items.php?action=approve&userid=" . $row['ItemID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";
            
                                     
                                   }
                                      echo "</td>";
                                      echo "</tr>";
                                   }
                                  
                                   ?>
                                   
                                </table>
                                </div>
                         <a href="items.php?action=add"  class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
                                </div> 
               <?php
               }//if
               else{
                echo "<div class='container'>";
                echo '<div class="alert alert-info"> there\'s no record to show</div>' ;
                echo "</div>";
                echo "<div class='d-flex justify-content-center'>";
                echo '<a href="items.php?action=add"  class="btn btn-primary "><i class="fa fa-plus"></i> New Item</a>' ;
                echo "</div>";

          }
               ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		}elseif($action == 'add') {

            ?>

            <h1 class="text-center">Add New Item</h1>
               <div class="container ">
               <form class="form-horizontal center" action="?action=insert" method="post">
   
                   <!--name field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="name" class="form-control"  required ='required'  placeholder="name of the item"/>
                     </div>
                   </div>
                   <!--name field-->

                    <!--Description field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="description" class="form-control"  required ='required'  placeholder="Description of the item"/>
                     </div>
                   </div>
                   <!--Description field-->


                    <!--price field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Price</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="price" class="form-control"  required ='required'  placeholder="Price of the item"/>
                     </div>
                   </div>
                   <!--price field-->

                    <!--country field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Country</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="country" class="form-control"  required ='required'  placeholder="country of made"/>
                     </div>
                   </div>
                   <!--country field-->

                  <!-- image field
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Image</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="image" class="form-control"  required ='required'  placeholder="Image for the item"/>
                     </div>
                   </div>
                  image field -->

                    <!--status field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Status</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="status">
                             <option value="0">...</option>
                             <option value="1">New</option>
                             <option value="2">Like New</option>
                             <option value="3">Used</option>
                             <option value="4">Old</optio>
                            </select> 
                     </div>
                   </div>
                   <!--status field-->

                   <!--select member-->
                   <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Member</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="member">
                             <option value="0">...</option>
                             <?php 
                             $stm  = $con ->prepare(" SELECT * FROM users");
                             $stm  -> execute();
                             $users= $stm->fetchAll();
                             foreach($users as $user){
                                 echo " <option value='".$user['UserID']."'>" .$user['Username']."</option>";
                             }
                             ?>
                            </select> 
                     </div>
                   </div>
                   <!--select member-->

                    <!--select categories-->
                    <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Categories</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="categories">
                             <option value="0">...</option>
                             <?php 
                             $stm  = $con ->prepare("SELECT * FROM categories");
                             $stm  -> execute();
                             $users= $stm->fetchAll();
                             foreach($users as $user){
                                 echo " <option value='".$user['ID']."'>" .$user['Name']."</option>";
                             }
                             ?>
                            </select> 
                     </div>
                   </div>
                   <!--select categories-->

                   <!-- Start Submit Field -->
                   <div class="form-group form-group-lg">   
                    <div class="col-sm-offset-2 col-sm-10 ">
                     <input type="submit" value="Add Member" class="btn btn-primary btn-sm" />
                           </div>
                       </div>
                   <!-- End Submit Field -->
               </form>
                   </div>
   <?php
         //////////////////////////////////////////////////////////////////////////////////

		} elseif ($action == 'insert') {//1
            if($_SERVER['REQUEST_METHOD']== 'POST'){//2
                echo "<h1 class='text-center'>Insert Item</h1>";
                echo "<div class='container'>";
            $name        =$_POST['name'];
            $description =$_POST['description'];
            $price       =$_POST['price'];
            $country     =$_POST['country'];
            $status      =$_POST['status'];
            $member      =$_POST['member'];
            $categories  =$_POST['categories'];


        
            if(empty($name)){
                $formerrors[]= 'the name can\'t be <strong>empty</strong>';
            }if(empty($description)) {
                $formerrors[]= 'the description can\'t be <strong>empty</strong>';
            }if(empty($price)){
                $formerrors[]= 'the price can\'t be <strong>empty</strong>';
            }if(empty($country)){
                $formerrors[]= 'the country can\'t be <strong>empty</strong>';
            }if(empty($status)){
                $formerrors[]= 'the status can\'t be <strong>empty</strong>';
            }if(empty($member)){
                $formerrors[]= 'the member can\'t be <strong>empty</strong>';
            }if(empty($categories)){
                $formerrors[]= 'the categories can\'t be <strong>empty</strong>';
            }	
         }
         
        //validate the form
            $formerrors=array();
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">'.$error .'</div></br>';
           }
            
           if(empty($formerrors)){ //3
            //استعلام
               $stmt=$con->prepare("INSERT INTO items
                                         (Name ,Description , Price , Status , Date ,CountryMade ,CatID , MemberID)
                                    VALUE(:vname , :vdescription , :vprice , :vstatus ,now() ,:vcountry ,:vcatid , :vmemberid)");
            //تنفيذ للقيم اللى جايه من الفورم
               $stmt ->execute(array(
                  'vname' => $name  ,
                  'vdescription' => $description ,
                  'vprice'=>$price,
                  'vstatus'=>$status ,
                  'vcountry'=>$country,
                  'vmemberid'=>$member,
                  'vcatid'=>$categories 


                 ));
                
                 echo "<div class='container'>";
                 $msg='<div class="alert alert-success">' .$stmt->rowcount().'record inserted</div>' ;
                 redirectHome($msg);
                 echo "</div>"; 

                //3
     }else{
        $msg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

        redirectHome($msg);
    }
               echo '</div>';
         
        
        
    
         //end insert page

		} elseif ($action == 'edit') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']):0;
        $stmt = $con->prepare("SELECT * FROM  items WHERE  ItemID = ?");
        $stmt ->execute(array($itemid));
        $items = $stmt->fetch();
        $count = $stmt->rowCount();
		if($count  >0){
            ?>

            <h1 class="text-center">Edit Item</h1>
               <div class="container ">
               <form class="form-horizontal center" action="?action=update" method="post">
               <input type="hidden"  name="itemid" value="<?php echo $items['ItemID']; ?>" class="form-control"  required ='required'  />
 
                   <!--name field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="name" value="<?php echo $items['Name']; ?>" class="form-control"  required ='required'  />
                     </div>
                   </div>
                   <!--name field-->

                    <!--Description field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="description" value="<?php echo $items['Description']; ?>" class="form-control"  required ='required'  />
                     </div>
                   </div>
                   <!--Description field-->


                    <!--price field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Price</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="price" value="<?php echo $items['Price']; ?>" class="form-control"  required ='required' />
                     </div>
                   </div>
                   <!--price field-->

                    <!--country field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Country</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="country" value="<?php echo $items['CountryMade']; ?>" class="form-control"  required ='required'  placeholder="country of made"/>
                     </div>
                   </div>
                   <!--country field-->

                  <!-- image field
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Image</label>
                     <div class="col-sm-10 col-md-6">
                      <input type="text"  name="image" class="form-control"  required ='required'  placeholder="Image for the item"/>
                     </div>
                   </div>
                  image field -->

                    <!--status field-->
                  <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Status</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="status">
                             <option value="0" >...</option>
                             <option value="1" <?php if($items['Status'] == 1){echo 'selected';}  ?>  >New</option>
                             <option value="2" <?php if($items['Status'] == 2){echo 'selected';}  ?> >Like New</option>
                             <option value="3" <?php if($items['Status'] == 3){echo 'selected';}  ?> >Used</option>
                             <option value="4" <?php if($items['Status'] == 4){echo 'selected';}  ?> >Old</optio>
                            </select> 
                     </div>
                   </div>
                   <!--status field-->

                   <!--select member-->
                   <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Member</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="member">
                             <option value="0">...</option>
                             <?php 
                             $stm  = $con ->prepare(" SELECT * FROM users");
                             $stm  -> execute();
                             $users= $stm->fetchAll();
                             foreach($users as $user){
                                 echo "<option value='".$user['UserID']."' ";
                                  if($user['UserID'] == $items['MemberID']){
                                  echo 'selected';
                                 }echo ">".$user['Username']."</option>";
                             }
                             ?>
                            </select> 
                     </div>
                   </div>
                   <!--select member-->

                    <!--select categories-->
                    <div class="row form-group form-group-lg">
                   <label class="col-sm-2 control-label">Categories</label>
                     <div class="col-sm-10 col-md-6">
                         <select class="group-control" name="categories">
                             <option value="0">...</option>
                             <?php 
                             $stm  = $con ->prepare("SELECT * FROM categories");
                             $stm  -> execute();
                             $cats= $stm->fetchAll();
                             foreach($cats as $cat){
                                 echo "<option value='".$cat['ID']."' ";
                                 if($cat['ID'] == $items['CatID']){
                                 echo 'selected';
                                }echo ">".$cat['Name']."</option>";
                            }
                            ?>
                            </select> 
                     </div>
                   </div>
                   <!--select categories-->

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
    }else{
		echo "<div class='container'>";
		$msg = '<div class="alert alert-danger"> there is no such id</div>' ;
	    redirectHome($msg );
		echo "</div>";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
     //update


		} elseif ($action == 'update') {
            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";
           if($_SERVER['REQUEST_METHOD']== 'POST'){
            $id         =$_POST['itemid'];
            $name        =$_POST['name'];
            $description =$_POST['description'];
            $price       =$_POST['price'];
            $country     =$_POST['country'];
            $status      =$_POST['status'];
            $member      =$_POST['member'];
            $categories  =$_POST['categories'];


        
            if(empty($name)){
                $formerrors[]= 'the name can\'t be <strong>empty</strong>';
            }if(empty($description)) {
                $formerrors[]= 'the description can\'t be <strong>empty</strong>';
            }if(empty($price)){
                $formerrors[]= 'the price can\'t be <strong>empty</strong>';
            }if(empty($country)){
                $formerrors[]= 'the country can\'t be <strong>empty</strong>';
            }if(empty($status)){
                $formerrors[]= 'the status can\'t be <strong>empty</strong>';
            }if(empty($member)){
                $formerrors[]= 'the member can\'t be <strong>empty</strong>';
            }if(empty($categories)){
                $formerrors[]= 'the categories can\'t be <strong>empty</strong>';
            }	
         }
         
        //validate the form
            $formerrors=array();
            foreach($formerrors as $error){
                echo '<div class="alert alert-danger">'.$error .'</div></br>';
           }
            
           if(empty($formerrors)){ 
            //استعلام
               $stmt = $con->prepare("UPDATE items SET `Name`= ? ,`Description` =? ,Price =? , CountryMade=? ,`Status`=?, CatID =? , MemberID=? WHERE ItemID=?");
               $stmt ->execute(array($name ,$description ,$price ,$country  ,$status ,$member ,$categories ,$id));
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

		} elseif ($action == 'delete') {
            echo "<h1 class='text-center'>Delete Item</h1>";
	echo "<div class='container'>";
	$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']):0;
    $stmt = $con->prepare("SELECT * FROM  items WHERE  ItemID = ? LIMIT 1");
	$check =checkItem("ItemID", "items",$itemid );
	    if($check  >0){
	     	$stmt=$con->prepare("DELETE FROM items WHERE ItemID = :itemid");

		    $stmt->bindparam(':itemid' ,$itemid);
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


		} elseif ($action == 'approve') {
            echo "<h1 class='text-center'>Approve Member</h1>";
            echo "<div class='container'>";
            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']):0;
            $check =checkItem("ItemID", "items",$itemid );
                if($check  >0){
                    $stmt = $con->prepare("UPDATE items SET Approve =1 WHERE ItemID=?");
                    $stmt->execute(array($itemid));
                    $msg= '<div class="alert alert-success">'.$stmt->rowcount().'row approved</div>' ;
                    redirectHome($msg,'back' ,4);
                }else{
                  echo "<div class='container'>";
                  $msg = '<div class="alert alert-danger">this id no exist</div>' ;
                  redirectHome($msg );
                  echo "</div>";
                     }
                     echo '</div>';

		}

        include $tmp.'footer.php'; 

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>