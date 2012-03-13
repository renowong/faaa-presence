<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');

    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $agentid = $_POST['agentid'];
    
    $exist = isexist_presenceid($agentid,$day,$month,$year,$type);
    if($exist>0){
        //update;
        update($value,$exist);
    }else{
        //insert;
        insert($agentid,$day,$month,$year,$type,$value);
    }
    
function update($value,$presenceid){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `presence` SET `value`='%s' WHERE `presenceid`='%s'"
                     ,$value,$presenceid);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}

function isexist_presenceid($agentid,$day,$month,$year,$type){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("SELECT `presenceid` FROM `presence` WHERE `agentid`='%s' AND `day`='%s' AND `month`='%s' AND `year`='%s' AND `type`='%s' LIMIT 1"
                     ,$agentid,$day,$month,$year,$type);
    $result = $mysqli->query($query);
    $row_cnt = $result->num_rows;
    if($row_cnt>0){
        $row = $result->fetch_object();
        $id = $row->presenceid;
    }else{
        $id = 0;
    }
    $mysqli->close();
    return $id;
}

function insert($agentid,$day,$month,$year,$type,$value){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `presence` (`presenceid`,`agentid`,`day`,`month`,`year`,`type`,`value`) VALUES (NULL,'%s','%s','%s','%s','%s','%s')"
                     ,$agentid,$day,$month,$year,$type,$value);
    $mysqli->query($query);
    $mysqli->close();
}
?>