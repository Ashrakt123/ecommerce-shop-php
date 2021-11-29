<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#AppNav" aria-controls="AppNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="dashbord.php" class="navbar-brand"><?php echo lang('one')?></a>
        </div>

        <div class="collapse navbar-collapse" id="AppNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="categories.php?action=manage"><?php echo lang('two')?></a></li>
                <li class="nav-item active"><a class="nav-link" href="items.php"><?php echo lang('three')?></a></li>
                <li class="nav-item active"><a class="nav-link" href="members.php"><?php echo lang('four')?></a></li>
                <li class="nav-item active"><a class="nav-link" href="comments.php"><?php echo lang('com')?></a></li>
               



                <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
        </li> -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Esraa
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="members.php?action=edit&userid=<?php echo $_SESSION['ID']?>">Edit profile</a>
                        <a class="dropdown-item" href="../../../ecommerce/index.php">Visit Shop</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
                <!-- <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
        </li> -->
            </ul>
        </div>
    </div>
</nav>
</body>