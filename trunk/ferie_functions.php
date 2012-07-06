<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');


$f = $_POST['f'];

switch($f){
    case 'insert':
        insert($_POST['day'],$_POST['month'],$_POST['year']); 
    break;
    case 'list':
        list(); 
    break;
}


////////////////functions///////////////////////////

function list(){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT * FROM `feries` ORDER BY `year`,`month`,`day` DESC");
    $mysqli->query($query);
    $mysqli->close();
    print $query;
}

function insert($day,$month,$year){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `feries` (`ferieid`,`day`,`month`,`year`) VALUES (NULL,'%s','%s','%s')"
                     ,$day,$month,$year);
    $mysqli->query($query);
    $mysqli->close();
    print $query;
}
    
?>