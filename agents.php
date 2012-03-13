<?php
include_once('config.php');
include_once('agents_top.php');
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
        
        function update_agent(){
            var nom = $("#txt_nom").val();
            var prenom = $("#txt_prenom").val();
            var id = $("#editid").val();
            var svc = $("#slt_services").val();
            var actif;
            if($("#chk_actif").attr("checked")=="checked"){actif=1;}else{actif=0;};
            
            $.post("add_edit_agents.php", {id:id,nom:nom,prenom:prenom,svc:svc,actif:actif},
                function(response) {
                //readresponse(response);
                //alert(response);
                });
            window.location = 'agents.php';
        }
        
        function init_edit(){
            $("#txt_nom").val('');
            $("#txt_prenom").val('');
            $("#editid").val('');
            $("#slt_services option:eq(0)").attr("selected", "selected");
        }
        
        function load_agent(data){
            var ar_data = data.split("_");
            var active = ar_data[4];
            $("#editid").val(ar_data[0]);
            $("#txt_nom").val(ar_data[1]);
            $("#txt_prenom").val(ar_data[2]);
            if(active==1){$("#chk_actif").attr("checked", true);}else{$("#chk_actif").attr("checked", false);}
            //$('#slt_services')
            //    .prepend($("<option></option>")
            //    .attr("value",ar_data[3])
            //    .text(ar_data[3]));
            $("#slt_services").val(ar_data[3]).attr("selected", "selected");
        }
    </script>
</head><body>
<? print $menu ?>
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
            <select id='slt_agents' name='slt_agents' onchange='load_agent(this.value);'>
                <option>Selectionner Agent</option>
                <? print $agents ?>
            </select>
            <br/>
            <button onclick='init_edit();'>Ajouter Nouvel Agent</button>
            <hr/>
            <div id='editagent'>
                <h1>Edition</h1>
                <input type='hidden' id='editid' name='editid'/>
                Compte Actif : <input type='checkbox' id='chk_actif' name='chk_actif' checked/><br/>
                Nom : <input type='text' id='txt_nom' name='txt_nom' style='text-transform:uppercase;'/><br/>
                Prenom : <input type='text' id='txt_prenom' name='txt_prenom' style='text-transform:capitalize;'/><br/>
                Service : <select id='slt_services' name='slt_services'>
                <? print $lst_services ?>
                </select>
                <br/>
                <button onclick='update_agent();'>Ajouter</button>
            </div>
        </td>
    </tr>
</table>
    
</body></html>