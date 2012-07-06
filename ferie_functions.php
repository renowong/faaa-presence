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
    $query = sprintf("SELECT * FROM `feries` WHERE `year`='%s' ORDER BY `year`,`month`,`day` ASC",$year);
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
    $feriedata = getdataferie($id);
    $ar_feriedata = explode("-",$feriedata);
    $query = sprintf("DELETE FROM `feries` WHERE `ferieid`='%s'"
                     ,$id);
    $mysqli->query($query);
    $query = sprintf("DELETE FROM `presence` WHERE `day`='%s' AND `month`='%s' AND `year`='%s'"
                     ,$ar_feriedata[2],$ar_feriedata[1],$ar_feriedata[0]);
    $mysqli->query($query);
    $mysqli->close();
    print $query;
}

function getdataferie($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT `day`,`month`,`year` FROM `feries` WHERE `ferieid`='%s'",$id);
    $result = $mysqli->query($query);

    $row = $result->fetch_row();
    if(substr($row[0],0,1)=="0") {$row[0] = substr($row[0],1);}
    $feriesdata=$row[2]."-".$row[1]."-".$row[0];

    $mysqli->close();
    return $feriesdata;
}
    
?>