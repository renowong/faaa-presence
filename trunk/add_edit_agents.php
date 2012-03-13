<?php
include_once('config.php');
    
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $svc = $_POST['svc'];
    
    if($id>0){
        print update($id,$nom,$prenom,$svc); 
    }else{
       print insert($nom,$prenom,$svc); 
    }
    

    
function update($id,$nom,$prenom,$svc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `agents` SET `nom`='%s',`prenom`='%s',`service`='%s' WHERE `agentid`='%s'"
                     ,$nom,$prenom,$svc,$id);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}


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