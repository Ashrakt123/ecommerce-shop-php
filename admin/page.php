<?php
//condition?true:false;
$action= isset($_GET['action'])? $_GET['action']:'manage';
 
/*
$action='';
if(isset($_GET['action'])){
    $action= $_GET['action'];
 }
 else{
     $action ='manage';
 }*/

if($action == 'manage'){
    echo 'manage page';
    echo '<a href="page.php?action=add">add</a>';
}
elseif($action == 'add'){
    echo 'add page';
}
elseif($action == 'insert'){
        echo 'insert page';
}
else {
    echo 'error';
}