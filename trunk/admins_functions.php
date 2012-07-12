<?php
include_once('config.php');
$list = $_POST["list"];

switch($list){
	case "slt_services":
		print getlist_services();
	break;
	case "slt_users":
		print getusers();
	break;
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

function getusers(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `users` ORDER BY `userlastname`");
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