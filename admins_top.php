<?php
if($_COOKIE['user']==''){header("Location: index.php");}

$lst_services = getlist_services();
$users = getusers();


function getlist_services(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `services` ORDER BY `designation`");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        $output .= "<option value='".$row->designation."'>".strtoupper($row->designation)."</option>";            
        }
        $mysqli->close();
        
        return $output;
}

function getusers(){
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `users` ORDER BY `userlastname`");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        $output .= "<option value='".$row->userid."_".$row->userlogin."_".$row->userlastname."_".$row->userfirstname."_".$row->userservice."_".$row->userisactive."'>".$row->userlastname." ".$row->userfirstname." (".$row->userlogin.")</option><br/>";            
        }
        $mysqli->close();
        
        return $output;
}
?>