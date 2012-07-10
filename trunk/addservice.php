<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');

    $s = $_POST['s'];
    $t = $_POST['t'];
    
    switch($t){
        case "insert":
            print insert($s);
            break;
        
        case "delete":
            print delete($s);
            break;
    }
    

    
//function update($value,$presenceid){
//    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
//    ////set the query
//    $query = sprintf("UPDATE `presence` SET `value`='%s' WHERE `presenceid`='%s'"
//                     ,$value,$presenceid);
//    $mysqli->query($query);
//    $mysqli->close();
//    return $query;
//}


function insert($s){
    if(!checkexist($s)){
        $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `services` (`designation`) VALUES ('%s')"
                     ,$s);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
    }
}

function delete($s){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("DELETE FROM `services` WHERE `idservice`='%s'"
                     ,$s);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}

function checkexist($s){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT * FROM `services` WHERE `designation`='%s'"
                     ,$s);
    $result = $mysqli->query($query);
    $num_rows = mysqli_num_rows($result);
    $mysqli->close();
    
    if($num_rows>0){
        return true;
    }else{
        return false;
    }
}
?>