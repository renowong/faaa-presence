<?php
include_once('config.php');
    
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $svc = $_POST['svc'];
    
    if($id>0){
        
    }else{
       print insert($nom,$prenom,$svc); 
    }
    

    
//function update($value,$presenceid){
//    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
//    ////set the query
//    $query = sprintf("UPDATE `presence` SET `value`='%s' WHERE `presenceid`='%s'"
//                     ,$value,$presenceid);
//    $mysqli->query($query);
//    $mysqli->close();
//    return $query;
//}


function insert($nom,$prenom,$svc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `agents` (`nom`,`prenom`,`service`) VALUES ('%s','%s','%s')"
                     ,$nom,$prenom,$svc);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}
?>