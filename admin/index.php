<?php 
session_start();
$nonavbar ='';
$pageTitle ='login';
//print_r($_SESSION);

include 'ini.php';
//include $tmp.'header.php'; 
 
//include 'includes/languages/arabic.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['user'];
    $password = $_POST['Pass'];
    $hashpass = sha1($password);

// check if the user exist in the DB
 $stmt = $con->prepare("SELECT UserID, Username, Pass
                        FROM  users 
                         WHERE  Username = ? 
                         AND  Pass = ? 
                        /* AND GroupID =1*/
                         LIMIT 1");
 $stmt ->execute(array($username, $hashpass));
 $row = $stmt->fetch();
 $count = $stmt->rowCount();

 if($count > 0){
    $_SESSION['Username'] = $username; // Register Session Name
    $_SESSION['ID'] = $row['UserID']; // Register Session ID
    header('Location:dashbord.php'); // Redirect To Dashboard Page
    exit();
 }
}
?>
<form class="login" action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
<h4 class="text-center">Admin Login </h4>
<input class="form-control input-lg" type="text" name ="user" placeholder="username" autocomplete="off" />
<input class="form-control  input-lg" type="password" name ="Pass" placeholder="password" autocomplete="new-password"/>
<input class="btn btn-primary btn-block" type="submit" value="login"/>
</form>

<?php 
include $tmp.'footer.php'; ?>