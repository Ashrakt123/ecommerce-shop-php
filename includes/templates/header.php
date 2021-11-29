<!DOCTYPE html>
    <head>
        <meta charset="UTF-8" />
		<title><?php getTitle() ?></title>
        <link rel="stylesheet" href= "<?php echo $css?>bootstrap.min.css" > 
        <link rel="stylesheet" href="<?php echo $css?>font-awesome.css" >
        <link rel="stylesheet" href="<?php echo $css?>jquery-ui.css" >
        <link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css" >
        <link rel="stylesheet" href="<?php echo $css?>backend.css" >



    </head>
    <body>
        <div class="upper-bar">
            <div class="container">
                <?php
                if(isset($_SESSION['User'])){
                   echo "Welcome"." " . $_SESSION['User'];
                }else{
                ?>
                <a href="login.php">
                    <span class="pull-right">Login / Signup</span>
                </a>
                <?php }?>
            </div>
        </div>

    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#AppNav" aria-controls="AppNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="../ecommerce/index.php" class="navbar-brand"><?php echo lang('one')?></a>
        </div>

            <ul class="nav navbar-nav navbar-right">
                  <?php  
                     foreach(getcat() as $cat){
                     echo "<li><a class='nav-link' href='../ecommerce/categories.php?pageid=". $cat['ID'] .
                     '&pageName='.str_replace(' ',' ',$cat['Name'])."'>". $cat['Name']." </a></li>";
                     }
                ?>
                                                  
               



                <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
        </li> -->
            </ul>

           <!-- <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Esraa
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="members.php?action=edit&userid=<?php echo $_SESSION['ID']?>">Edit profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
               <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
        </li> 
            </ul>-->
        
    </div>
</nav>