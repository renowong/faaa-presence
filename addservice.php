<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');

    $s = $_POST['s'];
    
    print insert($s);

    
function update($value,$presenceid){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `presence` SET `value`='%s' WHERE `presenceid`='%s'"
                     ,$value,$presenceid);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}


function insert($s){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `services` (`designation`) VALUES ('%s')"
                     ,$s);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}
?>