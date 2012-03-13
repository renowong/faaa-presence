<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');
    
    $id = $_POST['id'];
    $nom = strtoupper($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $svc = $_POST['svc'];
    $actif = $_POST['actif'];
    
    if($id>0){
        print update($id,$nom,$prenom,$svc,$actif); 
    }else{
       print insert($nom,$prenom,$svc,$actif); 
    }
    

    
function update($id,$nom,$prenom,$svc,$actif){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `agents` SET `nom`='%s',`prenom`='%s',`service`='%s',`active`='%s' WHERE `agentid`='%s'"
                     ,$nom,$prenom,$svc,$actif,$id);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}


function insert($nom,$prenom,$svc,$actif){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `agents` (`nom`,`prenom`,`service`,`active`) VALUES ('%s','%s','%s','%s')"
                     ,$nom,$prenom,$svc,$actif);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}
?>