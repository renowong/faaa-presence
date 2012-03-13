<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');
    
    $id = $_POST['id'];
    $login = strtolower($_POST['login']);
    $nom = strtoupper($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $svc = $_POST['svc'];
    $actif = $_POST['actif'];
    
    if($id>0){
       print update($id,$login,$nom,$prenom,$svc,$actif); 
    }else{
       print insert($login,$nom,$prenom,$svc,$actif); 
    }
    

    
function update($id,$login,$nom,$prenom,$svc,$actif){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `users` SET `userlogin`='%s',`userlastname`='%s',`userfirstname`='%s',`userservice`='%s',`userisactive`='%s' WHERE `userid`='%s'"
                     ,$login,$nom,$prenom,$svc,$actif,$id);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}


function insert($login,$nom,$prenom,$svc,$actif){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `users` (`userlogin`,`userlastname`,`userfirstname`,`userservice`,`userisactive`) VALUES ('%s','%s','%s','%s','%s')"
                     ,$login,$nom,$prenom,$svc,$actif);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}
?>