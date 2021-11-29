<?php 
session_start();
$pageTitle='Login';
if(isset($_SESSION['User'])){
    header('location:index.php');
}
include 'ini.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['name'];
    $password = $_POST['password'];
    $hashpass = sha1($password);
    $stmt = $con->prepare("SELECT Username, Pass
                        FROM  users 
                         WHERE  Username = ? 
                         AND  Pass = ? ");
    $stmt ->execute(array($username, $hashpass));
    $count = $stmt->rowCount();

     if($count > 0){
      $_SESSION['User'] = $username; // Register Session Name
      //print_r($_SESSION);
        header('Location:index.php'); 
        exit();
 }
}

?>
<div class="container login-page">
<h1 class="text-center">
        <span data-class="login">Login </span> | <span data-class="signup">Signup</span>
    </h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="star"><input class="form-control" type="text" required ="required" name="name" autocomplete="off" placeholder="type your user name"/></div>
      <div class="star"><input class="form-control" type="password" required ="required" name="password" autocomplete="new-password" placeholder="type your password"/></div>
      <input class="btn btn-primary btn-block" type="submit" value="login" />
    </form>
         <!-- end login form -->
            
    <!-- start signup form -->
    <form class="signup">
     <div class="star"><input class="form-control" type="text" required ="required" name="name" autocomplete="off" placeholder="type your name"/></div>
     <div class="star"><input class="form-control" type="email" required ="required" name="email" autocomplete="off" placeholder="type a valid email"/></div>
     <div class="star"><input class="form-control" type="password" required ="required" name="password" autocomplete="new-password" placeholder="type a complex password"/></div>
     <div class="star"><input class="form-control" type="password" required ="required" name="password-again" autocomplete="new-password" placeholder="type the password again"/></div>
     <input class="btn btn-success btn-block" type="submit" value="Signup" />
    </form>
         <!-- end signup form -->

</div>
<?php 
include $tmp.'footer.php'; ?>