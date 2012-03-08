<?php
include_once('config.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<response>';
echo query();
echo '</response>';


function query() {
	$login = $_POST['login'];
	$password = $_POST['password'];
	$sessionid;

	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `users` WHERE `userlogin`='%s' AND `userpassword`='%s' AND `userisactive`=1",$login,MD5($password));
	$result = $mysqli->query($query);

		if ($result){
			//no errors
			if ($result->num_rows == 0) {
				return "<access>Utilisateur non-autorisé</access><user><login></login>".
				"<password></password>".
				"<nom></nom>".
				"<prenom></prenom></user>";
			} else {
				$row = $result->fetch_object();
				return "<access>OK</access><user><userid>" . $row->userid . "</userid>".
				"<login>" . $row->userlogin . "</login>".
				"<password>" . $row->userpassword . "</password>".
				"<nom>" . $row->userlastname . "</nom>".
				"<prenom>" . $row->userfirstname . "</prenom></user>";
			}
		} else {
			echo $mysqli->error;
		}

		$mysqli->close();
}

?>