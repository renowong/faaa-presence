<?php
include_once('config.php');
include_once('presence_top.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title></title>
    <style type="text/css">@import url("css/main.css");</style>
        <!-- jquery -->
        <script type="application/x-javascript" src="js/jquery-1.7.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
        
        //load data
        var ids = $("#agentsids").val();
        var ar_ids = ids.split("|");
        for(i=0;i<ar_ids.length;i++){
            getdata($("#editmonth").val(),$("#edityear").val(),ar_ids[i]);
        }
        
        });
        
        
        
        function getdata(month,year,agentid){
            $.post("getdata.php", {month:month,year:year,agentid:agentid},
                function(response) {
                loaddata(response);
                //alert(response);
                });
            
        }
        
        function loaddata(xml){
            //alert("extracting xml");
            $(xml).find("data").each(function(){
                var tag = $(this).attr("idtag");
                var value = $(this).text();
                $("#"+tag).val(value);
             });
        }
        
        function loaddate(){
            var month = $("#slt_month").val();
            var year = $("#slt_annee").val();
            window.location = "presence.php?load=true&month="+month+"&year="+year;
        }
        
        function update(field){
            var fname = field.name;
            var fvalue = $("#"+fname).val();
            var editmonth = $("#editmonth").val();
            var edityear = $("#edityear").val();
            var arr = fname.split("_");
            var type = arr[0];
            var agentid = arr[1];
            var editday = arr[2];
            
            $.post("update.php", {year:edityear,month:editmonth,day:editday,type:type,value:fvalue,agentid:agentid},
			function(response) {
			//readresponse(response);
			//alert(response);
			});
            
        }
    </script>
</head><body>
<input type="hidden" id="editmonth" value="<? print $selectedmonth; ?>"/>
<input type="hidden" id="edityear" value="<? print $selectedyear; ?>"/>
<input type="hidden" id="agentsids" value="<? print $agentsids; ?>"/>
<button onclick="window.location='presence.php';">Mois en cours</button>
<p>Mois : <select id="slt_month">
    <? print $months ?>
</select>
Ann&eacute;e :
<select id="slt_annee">
    <? print $years ?>
</select>
<button onclick="loaddate();">Charger</button>
</p>
<table>
  <tbody>
    <tr>
      <td>Agent
      </td>
      <td>HA/HD
      </td>
        <? print buildcol("num","",$selectedmonth,$selectedyear) ?>
      <td>Total
      </td>
    </tr>
    <?
    foreach ($ar_agents as &$ar_agent){
        print "<tr>";
        print "<td style=\"vertical-align: top;\">".$ar_agent[1]."</td>";
        print "<td style=\"vertical-align: top;\">HA</td>";
        print buildcol("ha",$ar_agent[0],$selectedmonth,$selectedyear);
        print "<td colspan=\"1\" rowspan=\"2\" style=\"vertical-align: top;\">";
        print "<span id=\"total_".$ar_agent[0]."\" />";
        print "</td></tr>";
        print "<tr>";
        print "<td style=\"vertical-align: top;\">".$ar_agent[2]."</td>";
        print "<td style=\"vertical-align: top;\">HD</td>";
        print "</td>";
        print buildcol("hd",$ar_agent[0],$selectedmonth,$selectedyear);
        print "</tr>";
    }
    ?>
  </tbody>
</table>
<br>
</body></html>