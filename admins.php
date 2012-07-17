<?php
if($_COOKIE['user']=='' || !$_COOKIE['isadmin']){header("Location: index.php");}

include_once('headers.php');
//include_once('admins_top.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
    <?php echo $title.$icon.$charset.$cssreset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss ?>
        <!-- jquery -->
        <script type="text/javascript">
        $(document).ready(function () {
        
        $( "input:submit, button" ).button();
        getlist("slt_services");
        getlist("slt_users");
        });
        
        function getlist(t){
            $.post("admins_functions.php", {list:t},
                function(response) {
                //alert(response);
                var obj = jQuery.parseJSON(response);
                var count = obj.length-1;
                $("#"+t).empty();

                switch(t){
                    case "slt_services":
                        for(i=0;i<=count;i++){
                            $("#"+t).append('<option value='+obj[i].designation.toUpperCase()+'>'+obj[i].designation.toUpperCase()+'</option>');
                        }
                    break;
                    case "slt_users":
                        $("#"+t).append('<option>S\351lectionner Agent</option>');
                        for(i=0;i<=count;i++){
                            $("#"+t).append('<option value='+obj[i].userid+'_'+obj[i].userlogin+'_'+obj[i].userlastname+'_'+obj[i].userfirstname+'_'+obj[i].userservice.toUpperCase()+'_'+obj[i].userisactive+'>'+obj[i].userlastname.toUpperCase()+' '+obj[i].userfirstname+' ('+obj[i].userlogin+')</option>');
                        }
                    break;
                }
                
            });
        }
        
       
        function update_user(){
            var checklist = true;
            var login = $("#txt_login").val();
            var nom = $("#txt_nom").val();
            var prenom = $("#txt_prenom").val();
            var password = $("#txt_password").val();
            var id = $("#editid").val();
            var svc = $("#slt_services").val();
            var actif;
            if($("#chk_actif").is(":checked")){actif=1;}else{actif=0;};
            if(id.length==0 && password.length==0){message("Veuillez entrer un mot de passe");checklist=false;$("#txt_password").focus();}
            if(prenom.length==0){message("Veuillez entrer un pr\351nom");checklist=false;$("#txt_prenom").focus();}
            if(nom.length==0){message("Veuillez entrer un nom");checklist=false;$("#txt_nom").focus();}
            if(login.length==0){message("Veuillez entrer un login");checklist=false;$("#txt_login").focus();}

            if(checklist){
                $.post("add_edit_users.php", {id:id,login:login,nom:nom,prenom:prenom,password:password,svc:svc,actif:actif},
                function(response) {
                //readresponse(response);
                message("Ajout/Mise \340 effectu\351e");

                getlist("slt_users");
                });
            }
        }
        
        function init_edit(){
            $("#txt_login").val('');
            $("#txt_nom").val('');
            $("#txt_prenom").val('');
            $("#editid").val('');
            $("#slt_services option:eq(0)").prop("selected", "selected");
            $("#slt_users option:eq(0)").prop("selected", "selected");
            $("#chk_actif").prop("checked","checked");
            $("#labelinputs").html("Ajouter un utilisateur");
            $("#btn_validate").button("option","label","Ajouter");
        }
        
        function load_user(data){
            var ar_data = data.split("_");
            var active = ar_data[5];
            $("#editid").val(ar_data[0]);
            $("#txt_login").val(ar_data[1]);
            $("#txt_nom").val(ar_data[2]);
            $("#txt_prenom").val(ar_data[3]);
            if(active==1){$("#chk_actif").prop("checked", true);}else{$("#chk_actif").prop("checked", false);}
            $("#slt_services").val(ar_data[4]).prop("selected", "selected");
            $("#labelinputs").html("Edition d'un compte");
            $("#btn_validate").button("option","label","Mettre &agrave; jour");
        }
    </script>
</head><body>
<div name="message" id="message" ></div>
<? print $menu ?>
    <table>
        <th colspan="2">Gestion des acc&egrave;s</th>
        <tr>
            <td colspan="2">
            Edition
            <select id='slt_users' name='slt_users' onchange='load_user(this.value);'>
            </select>
            |
            <button onclick='init_edit();'>RAZ</button>
            </td>
        </tr>
          
            <th colspan="2"><div id="labelinputs">Ajouter un utilisateur</div></th>
            <tr>
                <td colspan="2"><input type='hidden' id='editid' name='editid'/>
                Compte Actif : <input type='checkbox' id='chk_actif' name='chk_actif' checked/>
                </td>
            </tr>
            <tr>
                <td>Login :</td>
                <td><input type='text' id='txt_login' name='txt_login' style='text-transform:lowercase;' /></td>
            </tr>
            <tr>
                <td>Nom :</td>
                <td><input type='text' id='txt_nom' name='txt_nom' style='text-transform:uppercase;' /></td>
            </tr>
            <tr>
                <td>Pr&eacute;nom :</td>
                <td><input type='text' id='txt_prenom' name='txt_prenom' style='text-transform:capitalize;' /></td>
            </tr>
            <tr>
                <td>Mot de passe :</td>
                <td><input type='password' id='txt_password' name='txt_password' />
                <br/><span class="note">Laisser vide pour garder l'ancien mot de passe</span></td>
            </tr>
            <tr>
                <td>Service :</td>
                <td><select id='slt_services' name='slt_services'><? print $lst_services ?></select></td>
            </tr>
            <tr><td colspan="2"><button id="btn_validate" onclick='update_user();'>Ajouter</button></td>
        </tr>
    </table>
</body></html>