<?php
include_once('config.php');
include_once('agents_top.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title></title>
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
                alert(response);
                });
        }
        
        function update_agent(){
            var nom = $("#txt_nom").val();
            var prenom = $("#txt_nom").val();
            var id = $("#editid").val();
            var svc = $("#slt_services").val();
            
            $.post("add_edit_agents.php", {id:id,nom:nom,prenom:prenom,svc:svc},
                function(response) {
                //readresponse(response);
                alert(response);
                });
        }
    </script>
</head><body>
<table width='100%'>
    <tr>
        <td width='20%'>
            <h1>Services</h1>
            <div id="list_services">
            <? print $services ?>
            </div>
            <input type='text' size='10' maxlength='10' id='txt_service' name='txt_service'/><button onclick='addsvc();'>Ajouter Service</button>
        </td>
        <td>
            <h1>Gestion Agents</h1>
            Edition
            <select id='slt_agents'>
                <option>Selectionner Agent</option>
                <? print $agents ?>
            </select>
            <br/>
            <button>Ajouter Nouvel Agent</button>
            <hr/>
            <div id='editagent'>
                <h1>Edition</h1>
                <input type='hidden' id='editid' name='editid'/>
                Nom : <input type='text' id='txt_nom' name='txt_nom' /><br/>
                Prenom : <input type='text' id='txt_prenom' name='txt_prenom' /><br/>
                <select id='slt_services' name='slt_services'>
                <? print $lst_services ?>
                </select>
                <br/>
                <button onclick='update_agent();'>Ajouter</button>
            </div>
        </td>
    </tr>
</table>
    
</body></html>