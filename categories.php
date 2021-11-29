<?php 

include 'ini.php';
?>
<div class="container">
    <h1 class="text-center"> <?php echo $_GET['pageName']; ?></h1>
    <div class='row'>
    <?php 

    foreach(getitem($_GET['pageid']) as $item){
        echo '<div class="col-sm-6 col-md-3">';
        echo '<div class="thumbnail item-box">';
            echo '<span class="price-tag">' . $item['Price'] . '</span>';
            echo '<img class="img-responsive" src="layout\images\img.png" alt="" />';
            echo '<div class="caption">';
                echo '<h3><a href="#">' . $item['Name'] .'</a></h3>';
                echo '<p>' . $item['Description'] . '</p>';
                echo '<div class="date">' . $item['Date'] . '</div>';
            echo '</div>';//caption
        echo '</div>';//item-box
    echo '</div>';
    }
  ?>
</div>
</div>

<?php
include $tmp.'footer.php'; ?>