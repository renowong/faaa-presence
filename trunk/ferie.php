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
            $('#datepicker').datepicker({
                    inline: true
            });
            
            $('#btn_ajouter').click(function(){
                var date = $("#datepicker").val();
                var ar_date = date.split("/");
                var day = ar_date[0];
                var month = ar_date[1];
                var year = ar_date[2];
                
                $.post("ferie_functions.php",{f:"insert",year:year,month:month,day:day},
                    function(response) {
                        //readresponse(response);
                        alert(response);
                });
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
            <p>Date: <input type="text" id="datepicker"> <button id="btn_ajouter">Ajouter</button></p>
        </td>
    </tr>
</table>
    
</body></html>