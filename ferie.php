<?php
include_once('config.php');
include_once('headers.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
    <?php echo $title.$icon.$charset.$cssreset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss.$datetimepickerjs ?>
        <!-- jquery -->
        
        <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                    beforeShowDay: $.datepicker.noWeekends,
                    minDate: 0,
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
                        //alert(response);
                        loadlist();
                });
            });

            loadlist();
            $( "input:submit, button" ).button();
        });
        
        function loadlist(){
            var d = new Date();
            var year = d.getFullYear();

            $.post("ferie_functions.php",{f:"list",year:year},
                    function(response) {
                        $("#ferielist").empty();
                        $("#ferielist").html(response);
                });
        }
        
        function deleteferie(id){
            $.post("ferie_functions.php",{f:"delete",ferieid:id},
                function(response) {
                    //alert(response);
                    loadlist();
            });
        }
        
    </script>
</head><body>
<div name="message" id="message" ></div>
<? print $menu ?>
            <table>
                <th>Gestion des F&eacute;ri&eacute;s</th>
                <tr>
                    <td>
                        Date <input type="text" id="datepicker"> <button id="btn_ajouter">Ajouter</button></p>
                    </td>
                </tr>
                <th>F&eacute;ri&eacute;s de cette ann&eacute;e</th>
                <tr>
                    <td>
                        <div id="ferielist" />
                        </td>
                </tr>
            </table>
</body></html>