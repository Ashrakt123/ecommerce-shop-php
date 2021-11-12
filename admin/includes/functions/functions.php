<?php
function getTitle() {

    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;

    } else {

        echo 'Default';

    }
}


//////////////////////////////////////////////////////

      function redirectHome($msg,$url=null,$seconds =3){
       if($url === null){
           $url ="index.php";
       }else{
               if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
                 $url=$_SERVER['HTTP_REFERER'];
               }else{
                 $url="index.php";
                    }
            }
           echo $msg;
           echo "<div class='alert alert-info'>You Will Be Redirected to $url After $seconds Seconds.</div>";           header("refresh:$seconds;url=$url");
           exit();
                                                
                                                }


///////////////////////////////////////////////////////////

    /*
                function to check items database
	** $select = The Item To Select [ Example: username, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/
    function checkItem($select ,$from ,$value){
        global $con;
        $statement =$con->prepare("SELECT $select FROM $from WHERE $select= ?");
        $statement-> execute(array($value));
        $count = $statement->rowcount();
        return $count;
    }

/*
	** Count Number Of Items Function v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countItems($item, $table) {
        global $con;
    $stm2 =$con->prepare("SELECT COUNT($item)FROM $table");
    $stm2->execute();
    return $stm2->fetchColumn();
}
  

    // get latest items
     function latestItems($select , $table, $order , $limit=5){
         global $con ;
         $stat2 = $con ->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
         $stat2 ->execute();
         $rows = $stat2->fetchAll();
         return $rows ;

     }