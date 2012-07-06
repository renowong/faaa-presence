<?php
include_once('config.php');

$year = $_POST['year'];
$month = $_POST['month'];

    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT `day` FROM `feries` WHERE `year`='%s' AND `month`='%s'",$year,$month);
    $result = $mysqli->query($query);
    while($row = $result->fetch_row()) {
            $feries[]=$row[0];
    }
    $mysqli->close();
    //echo $query;
    print json_encode($feries);


?>