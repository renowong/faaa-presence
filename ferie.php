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
        <script type="application/x-javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
        
       
        });
        
    </script>
</head><body>
<? print $menu ?>
<table width='100%'>
    <tr>
        <td>
            <h1>Gestion des F&eacute;ri&eacute;s</h1>
            <input type="text" name="fdate" id="fdate"/> <button>Ajouter</button>
        </td>
    </tr>
</table>
    
</body></html>