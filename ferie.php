<?php
include_once('config.php');
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
            <h1>Gestion des F&eacute;ri&eacute;s</h1>

        </td>
    </tr>
</table>
    
</body></html>