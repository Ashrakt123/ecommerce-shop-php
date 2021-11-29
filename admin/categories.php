<?php
/*
================================================
== categories Page
================================================
*/

ob_start(); // Output Buffering Start

session_start();

$pageTitle = 'categories';

if (isset($_SESSION['Username'])) {

    include 'ini.php';

    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {
        $sort ='ASC';
        $sort_array =array('ASC' ,'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort =$_GET['sort'];
        }
        $stm =$con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stm ->execute();
        $cats =$stm->fetchAll();?>
        
     <h1 class="text-center">Manage Categories</h1>

     <div class="container categories">
      <div class="panel panel-default">

            <div class="panel-heading">
            <span><i class="fa fa-edit"></i>Manage Categories</span>
            <div class="option pull-right">
               <i class='fa fa-sort'></i>Ordering :[
               <a class="<?php if($sort == 'ASC'){ echo 'active'; } ?>" href="?action=manage&&sort=ASC"> ASC </a>|
               <a class="<?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?action=manage&&sort=DESC"> DESC </a>]
               <i class='fa fa-eye'></i>View :[
               <span class="active" data-view='full'>Full</span>|
               <span data-view='classic'>Classic</span>]
            </div>
            </div>

            <div class="panel-body">
            <?php
            foreach($cats as $cat){
                 echo "<div class='cat'>";
                 echo"<div class='hidden-buttons'>";
                 echo "<a href='categories.php?action=edit&catid=".$cat['ID']."'  class='btn btn-xs btn-primary'><i class='fa fa-edit'>Edit</i></a>";
                 echo "<a href='categories.php?action=delete&catid=".$cat['ID']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'>Delete</i></a>";
                 echo"</div>";

                echo "<h4>" . $cat['Name'] . '</h4>';
                echo "<div class='full-view'>";
                    echo "<p>"; if($cat['Description'] == '') { echo 'This category has no description'; } else { echo $cat['Description']; } echo "</p>";
                    if($cat['Visibility'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Hidden</span>'; } 
                    if($cat['Allow_comment'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i> Comment Disabled</span>'; }
                    if($cat['Allow_ad'] == 1) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i> Ads Disabled</span>'; }  
                echo "</div>";
                echo "</div>";//cat class
                echo "<hr>";
                       }
            ?>
        </div>

        </div>
        <div>
            <a class="btn-add btn btn-primary btn-sm" href="categories.php?action=add"><i class="fa fa-plus"></i>Add New Category</a>
        </div>
       </div>

        <?php

        /////////////////////////////////////////////////////////////////////////////////////

    } elseif ($action == 'add') {
        ?>
        
          <h1 class="text-center">Add New Category</h1>
          <div class="container">
          <form class="form-horizontal" action="?action=insert" method="post">

              <!--name of the category-->
             <div class="row form-group form-group-lg">
              <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                 <input type="text"  name="name" class="form-control" autocomplete="off" required ='required'  placeholder="name of the category"/>
                </div>
              </div>
              <!--name of the category-->

              <!--Description-->
              <div class="row form-group form-group-lg">
              <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                <input type="text" name="description" class="form-control"  placeholder="Description of the category"/>
                </div>
              </div>
               <!--Description-->

                <!--ordering-->
              <div class="row form-group form-group-lg">
              <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10">
                 <input type="text"  name="ordering"  class="form-control" placeholder="ordering Your category"/>
                </div>
              </div>
              <!--ordering-->

                <!--visibility-->
                <div class="row form-group form-group-lg">
              <label class="col-sm-2 control-label">visibile</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                 <input type="radio" id="visibile-yes" value="0" name="visibility" checked/>
                 <label for="visibile-yes">Yes</label>
                    </div>
                    <div>
                 <input type="radio" id="visibile-no" value="1" name="visibility" />
                 <label for="visibile-no">No</label>
                    </div>
                </div>
              </div>
              <!--visibility-->
              
               <!--allow-comment-->
               <div class="row form-group form-group-lg">
              <label class="col-sm-2 control-label">Allow Comment</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                 <input type="radio" id="comment-yes" value="0" name="comment" checked/>
                 <label for="comment-yes">Yes</label>
                    </div>
                    <div>
                 <input type="radio" id="comment-no" value="1" name="comment" />
                 <label for="comment-no">No</label>
                    </div>
                </div>
              </div>
              <!--allow-comment-->

              <!-- Start Ads Field -->
					<div class="row form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Ads Field -->


              <!-- Start Submit Field -->
              <div class="form-group form-group-lg">
                      <div class="col-sm-offset-2 col-sm-10">
                          <input type="submit" value="Add Category" class="btn btn-primary btn-sm" />
                      </div>
                  </div>
              <!-- End Submit Field -->
          </form>
              </div>
          
        


    <?php
    }
    //end add category

      //////////////////////////////////////////////////////////////////////////////

    // start insert category
    elseif($action == 'insert'){
   // echo $_POST['username'].$_POST['password'].$_POST['email'].$_POST['fullname'];
     
     if($_SERVER['REQUEST_METHOD']== 'POST'){
         echo "<h1 class='text-center'>Insert Category</h1>";
         echo "<div class='container'>";
      
     $name         =$_POST['name'];
     $description  =$_POST['description'];
     $ordering     =empty($_POST['ordering'])?NULL :$_POST['ordering'];
     $visibility   =$_POST['visibility'];
     $comment      =$_POST['comment'];
     $ads 		   = $_POST['ads'];

    
        $check=  checkItem("Name" ,"categories" ,$name);
          if($check ==1){
             echo "<div class='container'>";
             $msg='<div class="alert alert-success">sorry this categories is existed</div>' ;
             redirectHome($msg,'back' ,4);
             echo "</div>"; 
 
         
 
          }else{
             //استعلام
                $stmt=$con->prepare("INSERT INTO categories
                                          (`Name`   ,`Description` , Ordering ,Visibility , Allow_comment, Allow_ad)
                                   VALUES (:vname , :vdes , :vord , :vvisible , :vcomment ,:vad)");
             //تنفيذ للقيم اللى جايه من الفورم
                $stmt ->execute(array(
                   'vname'   =>$name ,
                   'vdes'    =>$description,
                   'vord'    =>$ordering,
                   'vvisible'=>$visibility,
                   'vcomment'=>$comment,
                   'vad'    => $ads
                ));

                  echo "<div class='container'>";
                  $msg='<div class="alert alert-success">' .$stmt->rowcount().'record inserted</div>' ;
                  redirectHome($msg,'back' ,4);
 
                 
      }
     
 
}//postelse
 {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg, 'back');

				echo "</div>";

			}

			echo "</div>";

            /////////////////////////////////////////////////////////////////////////

 
    }elseif ($action == 'edit') {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']):0;
		$stmt  = $con->prepare("SELECT * FROM  categories WHERE ID = ? ");
        $stmt  ->execute(array($catid));
        $cat   = $stmt->fetch();
        $count = $stmt->rowCount();
		if($count  >0){
    ?>
        <h1 class="text-center">Edit New Category</h1>
        <div class="container">
        <form class="form-horizontal" action="?action=update" method="post">
        <input type="hidden" value="<?php echo $catid ?>"  name="catid" />

            <!--name of the category-->
           <div class="row form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
               <input type="text"  name="name" value="<?php echo $cat['Name']?>" class="form-control"  required ='required'  placeholder="name of the category"/>
              </div>
            </div>
            <!--name of the category-->

            <!--Description-->
            <div class="row form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
              <input type="text" name="description" value="<?php echo $cat['Description']?>" class="form-control"  placeholder="Description of the category"/>
              </div>
            </div>
             <!--Description-->

              <!--ordering-->
            <div class="row form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
              <div class="col-sm-10">
               <input type="text"  name="ordering" value="<?php echo $cat['Ordering']?>" class="form-control" placeholder="ordering Your category"/>
              </div>
            </div>
            <!--ordering-->

              <!--visibility-->
              <div class="row form-group form-group-lg">
            <label class="col-sm-2 control-label">visibile</label>
              <div class="col-sm-10 col-md-6">
                  <div>
               <input type="radio" id="visibile-yes" value="0" name="visibility" <?php if($cat['Visibility'] == 0){ echo 'checked';}?> />
               <label for="visibile-yes">Yes</label>
                  </div>
                  <div>
               <input type="radio" id="visibile-no" value="1" name="visibility" <?php if($cat['Visibility'] == 1){ echo 'checked';}?> />
               <label for="visibile-no">No</label>
                  </div>
              </div>
            </div>
            <!--visibility-->
            
             <!--allow-comment-->
             <div class="row form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Comment</label>
              <div class="col-sm-10 col-md-6">
                  <div>
               <input type="radio" id="comment-yes" value="0" name="comment" <?php if($cat['Allow_comment'] == 0){ echo 'checked';}?>/>
               <label for="comment-yes">Yes</label>
                  </div>
                  <div>
               <input type="radio" id="comment-no" value="1" name="comment" <?php if($cat['Allow_comment'] == 1){ echo 'checked';}?> />
               <label for="comment-no">No</label>
                  </div>
              </div>
            </div>
            <!--allow-comment-->

            <!-- Start Ads Field -->
                  <div class="row form-group form-group-lg">
                      <label class="col-sm-2 control-label">Allow Ads</label>
                      <div class="col-sm-10 col-md-6">
                          <div>
                              <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_ad'] == 0){ echo 'checked';}?> />
                              <label for="ads-yes">Yes</label> 
                          </div>
                          <div>
                              <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_ad'] == 1){ echo 'checked';}?> />
                              <label for="ads-no">No</label> 
                          </div>
                      </div>
                  </div>
                  <!-- End Ads Field -->


            <!-- Start Submit Field -->
            <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="save" class="btn btn-primary btn-lg" />
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

///////////////////////////////////////////////////////////////////////////////////////////////

    } elseif ($action == 'update') {
        echo "<h1 class='text-center'>Update Categories</h1>";
        echo "<div class='container'>";
       if($_SERVER['REQUEST_METHOD']== 'POST'){

       $id          =$_POST['catid'];
       $name        =$_POST['name'];
       $description =$_POST['description'];
       $ordering    =$_POST['ordering'];
       $visibility  =$_POST['visibility'];
       $comment     =$_POST['comment'];
       $ads         =$_POST['ads'];

           $stmt = $con->prepare("UPDATE categories SET `Name`= ? , `Description`=? ,Ordering =? ,Visibility =? ,Allow_comment =? ,Allow_ad =? WHERE ID =?");
           $stmt ->execute(array($name ,$description ,$ordering,$visibility ,$comment ,$ads ,$id));
           $msg= '<div class="alert alert-success">' .$stmt->rowcount().'row updated</div>' ;
           redirectHome($msg,'back' ,4);

                            
        }else{
       echo "<div class='container'>";
       $msg = '<div class="alert alert-danger">sorry you cannt browse this page directly</div>' ;
       redirectHome($msg );
       echo "</div>";
   }
       echo '</div>';


    } elseif ($action == 'delete') {
        echo "<h1 class='text-center'>Delete Categoty</h1>";
        echo "<div class='container'>";
        $id= isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']):0;
        $check =checkItem("ID", "categories",$id );
            if($check  >0){
                $stmt=$con->prepare("DELETE FROM categories WHERE ID = :id");
                $stmt->bindparam(':id' ,$id);
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
    }   

    

    include $tmp.'footer.php'; 

} else {

    header('Location: index.php');

    exit();
}

ob_end_flush(); // Release The Output
?>

