<?php

$lst_services = getlist_services();
$services = getservices();
$agents = getagents();

function getservices(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `services`");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        $output .= "<span id='".$row->idservice."'>".$row->designation."</span><br/>";            
        }
        $mysqli->close();
        
        return $output;
}

function getlist_services(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `services`");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        $output .= "<option value='".$row->designation."'>".$row->designation."</option>";            
        }
        $mysqli->close();
        
        return $output;
}

function getagents(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `agents` ORDER BY `nom`");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        $output .= "<option value='".$row->agentid."'>".$row->nom." ".$row->prenom." (".$row->service.")</option><br/>";            
        }
        $mysqli->close();
        
        return $output;
}
?>