<?php
include_once('config.php');
$list = $_POST["list"];

switch($list){
	case "slt_agents":
		print getusers();
	break;
	case "slt_services":
		print getlist_services();
	break;
	case "list_services":
		print getlist_services();
	break;
}

function getusers(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `agents` ORDER BY `nom`");
	$result = $mysqli->query($query);
	
	$result_array = array();
	while($row = $result->fetch_assoc())
	{
	    $result_array[] = $row;
	}

        $mysqli->close();
        
        return json_encode($result_array);
}

function getlist_services(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	$query = sprintf("SELECT * FROM `services` ORDER BY `designation`");
	$result = $mysqli->query($query);
	
	$result_array = array();
	while($row = $result->fetch_assoc())
	{
	    $result_array[] = $row;
	}

        $mysqli->close();
        
        return json_encode($result_array);
}
?>