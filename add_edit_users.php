<?php
if($_COOKIE['user']==''){header("Location: index.php");}
include_once('config.php');
    
    $id = $_POST['id'];
    $login = strtolower($_POST['login']);
    $nom = strtoupper($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $password = md5($_POST['password']);
    if($password=='d41d8cd98f00b204e9800998ecf8427e') $password=getpassword($id);
    $svc = $_POST['svc'];
    $actif = $_POST['actif'];
    $admin = $_POST['admin'];
    
    if($id>0){
       print update($id,$login,$nom,$prenom,$password,$svc,$actif,$admin); 
    }else{
       print insert($login,$nom,$prenom,$password,$svc,$actif,$admin); 
    }
    
function getpassword($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("SELECT `userpassword` FROM `users` WHERE `userid`='%s'"
                     ,$id);
    $result = $mysqli->query($query);
    $row = $result->fetch_object();
    $password = $row->userpassword;
    $mysqli->close();
    return $password;
}
    
function update($id,$login,$nom,$prenom,$password,$svc,$actif,$admin){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("UPDATE `users` SET `userlogin`='%s',`userlastname`='%s',`userfirstname`='%s',`userpassword`='%s',`userservice`='%s',`userisactive`='%s',`userisadmin`='%s' WHERE `userid`='%s'"
                     ,$login,$nom,$prenom,$password,$svc,$actif,$admin,$id);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}


function insert($login,$nom,$prenom,$password,$svc,$actif,$admin){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    ////set the query
    $query = sprintf("INSERT INTO `users` (`userlogin`,`userlastname`,`userfirstname`,`userpassword`,`userservice`,`userisactive`,`userisadmin`) VALUES ('%s','%s','%s','%s','%s','%s','%s')"
                     ,$login,$nom,$prenom,$password,$svc,$actif,$admin);
    $mysqli->query($query);
    $mysqli->close();
    return $query;
}
?>