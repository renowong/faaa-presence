<?php
include_once('config.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<response>';
echo query();
echo '</response>';


function query() {
	$year = $_POST['year'];
	$month = $_POST['month'];
	$agentid = $_POST['agentid'];

	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `presence` WHERE `year`='%s' AND `month`='%s' AND `agentid`='%s'",$year,$month,$agentid);
	$result = $mysqli->query($query);

		if ($result){
                    while($row = $result->fetch_object()){
                    $idtag = $row->type."_".$row->agentid."_".$row->day;
                    $xml .= "<data idtag='$idtag'>".$row->value."</data>";            
                    }
		} else {
		    echo $mysqli->error;
		}
		$mysqli->close();
        return $xml;
}

?>