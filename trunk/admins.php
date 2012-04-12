<?php
include_once('config.php');
include_once('admins_top.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title></title>
    <link rel="stylesheet" type="text/css" href="css/csshorizontalmenu.css" />
    <script type="text/javascript" src="js/csshorizontalmenu.js"></script>
    <style type="text/css">@import url("css/main.css");</style>
        <!-- jquery -->
        <script type="application/x-javascript" src="js/jquery-1.7.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
        
       
        });
        
        function addsvc(){
            var newsvc = $("#txt_service").val();
            if (newsvc=='') {
                alert("aucune entr\351e!");
            }else{
                sendsvc(newsvc);
            }
        }
        
        function sendsvc(s){
            $.post("addservice.php", {s:s},
                function(response) {
                //readresponse(response);
                //alert(response);
                });
            window.location = 'agents.php';
        }
        
        function update_user(){
            var login = $("#txt_login").val();
            var nom = $("#txt_nom").val();
            var prenom = $("#txt_prenom").val();
            var password = $("#txt_password").val();
            var id = $("#editid").val();
            var svc = $("#slt_services").val();
            var actif;
            if($("#chk_actif").attr("checked")=="checked"){actif=1;}else{actif=0;};
            
            $.post("add_edit_users.php", {id:id,login:login,nom:nom,prenom:prenom,password:password,svc:svc,actif:actif},
                function(response) {
                //readresponse(response);
                alert(response);
                });
            window.location = 'admins.php';
        }
        
        function init_edit(){
            $("#txt_login").val('');
            $("#txt_nom").val('');
            $("#txt_prenom").val('');
            $("#editid").val('');
            $("#slt_services option:eq(0)").attr("selected", "selected");
        }
        
        function load_user(data){
            var ar_data = data.split("_");
            var active = ar_data[5];
            $("#editid").val(ar_data[0]);
            $("#txt_login").val(ar_data[1]);
            $("#txt_nom").val(ar_data[2]);
            $("#txt_prenom").val(ar_data[3]);
            if(active==1){$("#chk_actif").attr("checked", true);}else{$("#chk_actif").attr("checked", false);}
            //$('#slt_services')
            //    .prepend($("<option></option>")
            //    .attr("value",ar_data[3])
            //    .text(ar_data[3]));
            $("#slt_services").val(ar_data[4]).attr("selected", "selected");
        }
    </script>
</head><body>
<? print $menu ?>
<table width='100%'>
    <tr>
        <td>
            <h1>Gestion Agents</h1>
            Edition
            <select id='slt_users' name='slt_users' onchange='load_user(this.value);'>
                <option>Selectionner Agent</option>
                <? print $users ?>
            </select>
            <br/>
            <button onclick='init_edit();'>Ajouter Nouvel Agent</button>
            <hr/>
            <div id='editagent'>
                <h1>Edition</h1>
                <input type='hidden' id='editid' name='editid'/>
                Compte Actif : <input type='checkbox' id='chk_actif' name='chk_actif' checked/><br/>
                Login : <input type='text' id='txt_login' name='txt_login' style='text-transform:lowercase;' /><br/>
                Nom : <input type='text' id='txt_nom' name='txt_nom' style='text-transform:uppercase;' /><br/>
                Pr&eacute;nom : <input type='text' id='txt_prenom' name='txt_prenom' style='text-transform:capitalize;' /><br/>
                Mot de passe : <input type='text' id='txt_password' name='txt_password' /> <i>Laisser vide pour garder l'ancien mot de passe</i><br/>
                Service : <select id='slt_services' name='slt_services'>
                <? print $lst_services ?>
                </select>
                <br/>
                <button onclick='update_user();'>Ajouter / Mettre &agrave; jour</button>
            </div>
        </td>
    </tr>
</table>
    
</body></html>