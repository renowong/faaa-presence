<?php
include_once('config.php');
include_once('headers.php');
include_once('agents_top.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
    <?php echo $title.$icon.$charset.$cssreset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss ?>

        <!-- jquery -->
        <script type="text/javascript">
        $(document).ready(function () {
        
        $( "input:submit, button" ).button();
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
                        <? print $services ?>
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
                            <option>Selectionner Agent</option>
                            <? print $agents ?>
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
                        <td><select id='slt_services' name='slt_services'><? print $lst_services ?></select></td>
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