<?php
if($_COOKIE['user']=='' || !$_COOKIE['isadmin']){header("Location: index.php");}

include_once('headers.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
    <?php echo $title.$icon.$charset.$cssreset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss ?>

        <!-- jquery -->
        <script type="text/javascript">
        $(document).ready(function () {
        getlist("slt_agents");
        getlist("slt_services");
        getlist("list_services");
        $( "input:submit, button" ).button();
        });
        
        function getlist(t){
            $.post("agents_functions.php", {list:t},
                function(response) {
                //alert(response);
                var obj = jQuery.parseJSON(response);
                var count = obj.length-1;
                $("#"+t).empty();

                switch(t){
                    case "slt_agents":
                        $("#"+t).append('<option>S\351lectionner Agent</option>');
                        for(i=0;i<=count;i++){
                            $("#"+t).append('<option value='+obj[i].agentid+'_'+obj[i].nom+'_'+obj[i].prenom+'_'+obj[i].service.toUpperCase()+'_'+obj[i].active+'>'+obj[i].nom.toUpperCase()+' '+obj[i].prenom+' ('+obj[i].service+')</option>');
                        }
                    break;
                    case "slt_services":
                        for(i=0;i<=count;i++){
                            $("#"+t).append('<option value='+obj[i].designation.toUpperCase()+'>'+obj[i].designation.toUpperCase()+'</option>');
                        }
                    break;
                    case "list_services":
                        for(i=0;i<=count;i++){
                            $("#"+t).append("<span id='"+obj[i].idservice+"'>"+obj[i].designation.toUpperCase()+"</span><a href='javascript:deletesvc("+obj[i].idservice+");'><img src='img/trash.png'/></a><br/>");
                        }
                    break;
                }
                
            });
        }
        
        function addsvc(){
            var newsvc = $("#txt_service").val();
            if (newsvc=='') {
                message("Aucune entr\351e!");
            }else{
                sendsvc(newsvc);
            }
        }
        
        function sendsvc(s){
            $.post("addservice.php", {s:s,t:"insert"},
                function(response) {
                //readresponse(response);
                getlist("list_services");
                getlist("slt_services");
                });
        }
        
        function deletesvc(s){
            $.post("addservice.php", {s:s,t:"delete"},
                function(response) {
                //readresponse(response);
                getlist("list_services");
                getlist("slt_services");
                });
        }
        
        function update_agent(){
            var nom = $("#txt_nom").val();
            var prenom = $("#txt_prenom").val();
            var id = $("#editid").val();
            var svc = $("#slt_services").val();
            var actif;
            if($("#chk_actif").is(":checked")){actif=1;}else{actif=0;};
            
            if(nom=="" || prenom==""){
                message("Veuillez compl\351ter le nom et le pr\351nom!");
            }else{
                 $.post("add_edit_agents.php", {id:id,nom:nom,prenom:prenom,svc:svc,actif:actif},
                function(response) {
                //readresponse(response);
                message("Ajout/Mise \340 effectu\351e");
                getlist("slt_services");
                getlist("slt_agents");
                init_edit();
                });
            }
        }
        
        function init_edit(){
            $("#txt_nom").val('');
            $("#txt_prenom").val('');
            $("#editid").val('');
            $("#slt_services option:eq(0)").prop("selected", "selected");
            $("#slt_agents option:eq(0)").prop("selected", "selected");
            $("#chk_actif").prop("checked","checked");
        }
        
        function load_agent(data){
            var ar_data = data.split("_");
            var active = ar_data[4];
            $("#editid").val(ar_data[0]);
            $("#txt_nom").val(ar_data[1]);
            $("#txt_prenom").val(ar_data[2]);
            if(active==1){$("#chk_actif").prop("checked", "checked");}else{$("#chk_actif").prop("checked", "");}
            $("#slt_services").val(ar_data[3]).prop("selected", "selected");
        }
    </script>
</head><body>
<div name="message" id="message" ></div>
<? print $menu ?>
<table>
    <tr>
        <td width='250px' style="vertical-align:top;">
            <table>
                <th>Services</th>
            <tr>
                    <td>
                        <input type='text' size='10' maxlength='10' id='txt_service' name='txt_service' style='text-transform: uppercase;'/> <button onclick='addsvc();'>Ajouter Service</button>
                    </td>
                </tr>
                <th>Liste des Services</th>
                <tr>
                    <td>
                        <div id="list_services">
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <th colspan="2">Gestion Agents</th>
            <tr>
                    <td colspan="2">Editer
                        <select id='slt_agents' name='slt_agents' onchange='load_agent(this.value);'>
                            <option>S&eacute;lectionner Agent</option>
                        </select> | <button onclick='init_edit();'>RAZ</button>
                    </td>
                </tr>
                    <th colspan="2">Edition</th>
                       </tr>     
                        <td><input type='hidden' id='editid' name='editid'/>Compte Actif :</td>
                        <td><input type='checkbox' id='chk_actif' name='chk_actif' checked/></td>
                    </tr>
                    <tr>
                        <td>Nom :</td>
                        <td><input type='text' id='txt_nom' name='txt_nom' style='text-transform:uppercase;'/></td>
                    </tr>
                    <tr>
                        <td>Pr&eacute;nom :</td>
                        <td><input type='text' id='txt_prenom' name='txt_prenom' style='text-transform:capitalize;'/></td>
                    </tr>
                    <tr>
                        <td>Service :</td>
                        <td><select id='slt_services' name='slt_services'></select></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button onclick='update_agent();'>Ajouter / Mettre &agrave; jour</button></td>
                    </tr>
                </table>
                
            </div>
        </td>
    </tr>
</table>
    
</body></html>