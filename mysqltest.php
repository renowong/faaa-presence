<?php
echo "testing connection";
$link = mysql_connect('192.168.0.4','root','topaze');
if (!$link) { die('Could not connect to MySQL: ' . mysql_error());} echo 'Connection OK';
mysql_close($link);

?>