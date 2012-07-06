<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');


$f = $_POST['f'];

switch($f){
    case 'insert':
        insert($_POST['day'],$_POST['month'],$_POST['year']); 
    break;
    case 'list':
        loadlist($_POST['year']); 
    break;
    case 'delete':
        delete($_POST['ferieid']); 
    break;
}


////////////////functions///////////////////////////

function loadlist($year){
    $thismonth = date("m");
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT * FROM `feries` WHERE `year`='$year' ORDER BY `year`,`month`,`day` ASC");
    $result = $mysqli->query($query);

    while($row = $result->fetch_object()){
        if($row->month>=$thismonth){$trash="<a href='javascript:deleteferie(".$row->ferieid.");'><img src='img/trash.png'/></a>";}else{$trash="";}
        $output .= $row->day."/".$row->month."/".$row->year." $trash<br/><br/>";
    }

    $mysqli->close();
    print $output;
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

function delete($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("DELETE FROM `feries` WHERE `ferieid`='%s'"
                     ,$id);
    $mysqli->query($query);
    $mysqli->close();
    print $query;
}
    
?>