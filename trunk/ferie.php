<?php
include_once('config.php');
include_once('headers.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
    <?php echo $title.$icon.$charset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss.$datetimepickerjs ?>
        <!-- jquery -->
        
        <script type="text/javascript">
        $(document).ready(function () {
            

	//$.datepicker.setDefaults($.datepicker.regional['fr']);
        
        
        $('#datepicker').datepicker({
                inline: true
        });

        });
        
    </script>
</head><body>
<div name="message" id="message" ></div>
<? print $menu ?>
<table width='100%'>
    <tr>
        <td>
            <h1>Gestion des F&eacute;ri&eacute;s</h1>
            <p>Date: <input type="text" id="datepicker"> <button>Ajouter</button></p>
        </td>
    </tr>
</table>
    
</body></html>