<?php
include_once('config.php');
include_once('presence_top.php');
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
                //alert(tag);
                calc(tag);
                
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
            //if(fvalue!=""){
                if(checkvalid(fvalue)){
                    $.post("update.php", {year:edityear,month:editmonth,day:editday,type:type,value:fvalue,agentid:agentid},
                            function(response) {
                            //readresponse(response);
                            //alert(response);
                            });
                }else{
                    alert("Entr\351e invalide!");
                    $("#"+fname).val("");
                }                
            //}
        }
        
        function checkvalid(input){
            var pattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            var pattern2 = /^(CP|AB|AM|CM|AT|CF|F)?$/i;
            if(pattern.test(input) || pattern2.test(input)){
                return true;}else{return false;}
        }
        
        function calc(field){
            var pattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            var pattern2 = /^(CP|AM|CM|AT|CF|F)$/i;
            var suffix = field.substring(2);
            var ha = $("#ha"+suffix).val();
            var hd = $("#hd"+suffix).val();
            var month = $("#slt_month").val();
            var year = $("#slt_annee").val();
            var day = suffix.substring(1);
            day = day.split("_");
            var d = new Date(year, month-1, day[1]);

            if(pattern2.test(ha)) {ha="7:30";} else {if(!pattern.test(ha)){ha="0:00";}}
            if(pattern2.test(hd)) {
                //alert(d.getDay());
                if(d.getDay()=="5"){
                    hd="14:30";
                }else{
                    hd="15:30";
                }
            }else{
                if(!pattern.test(ha)){hd="0:00";} 
            }
            var tt = new Date('01/01/2009 ' + hd)-new Date('01/01/2009 ' + ha);
            tt = tt/1000; //convert to seconds
            $("#tt"+suffix).val(tt);
            total(suffix);
        }
        
        function total(suffix){
            var id = suffix.substring(1);
            var explode = id.split("_");
            var total = 0;
            var tt;
            var heures=0;
            var minutes=0;
            var output;
            id = explode[0];
            
            for(i=1;i<32;i++){
                tt = $("#tt_"+id+"_"+i).val();
                
                if(tt==undefined || tt==""){tt=0;}
                total += tt*1;
            }
            minutes = total/60;
            if(minutes>=60){
                heures = minutes/60;
                minutes = minutes%60;
                heures = Math.floor(heures);
                minutes = Math.round(minutes*Math.pow(10,2))/Math.pow(10,2);
                
            }
            if(minutes<10) minutes = "0"+minutes;
            output = heures+":"+minutes;
            $("#span_total_"+id).html(output);
            $("#total_"+id).val(output);
        }
        
        function extract(){
            var month = $("#editmonth").val();
            var year = $("#edityear").val();
            var agents = $("#agentsids").val();
            var maxdays = $("#maxdays").val();
            var svc = $("#svc").val();
            var ar_agents = agents.split("|");
            var tt = "";
            for(i=0;i<ar_agents.length;i++){
                tt += "&"+ar_agents[i]+"="+$("#total_"+ar_agents[i]).val();
            }
            //alert('extract.php?month='+month+'&year='+year+'&agents='+agents+tt);
            window.location='extract.php?month='+month+'&year='+year+'&agents='+agents+'&svc='+svc+'&maxdays='+maxdays+tt;
        }
    </script>
</head><body>
<? print $menu ?>
<input type="hidden" id="editmonth" value="<? print $selectedmonth; ?>"/>
<input type="hidden" id="edityear" value="<? print $selectedyear; ?>"/>
<input type="hidden" id="agentsids" value="<? print $agentsids; ?>"/>
<input type="hidden" id="svc" value="<? print $service; ?>"/>
<input type="hidden" id="maxdays" value="<? print cal_days_in_month(CAL_GREGORIAN, $selectedmonth, $selectedyear); ?>"/>
<button onclick="window.location='presence.php';">Mois en cours</button><button onclick="extract();">Excel</button>
<p>Mois : <select id="slt_month">
    <? print $months ?>
</select>
Ann&eacute;e :
<select id="slt_annee">
    <? print $years ?>
</select>
<button onclick="loaddate();">Charger</button>
</p>
<form>
<table>
  <tbody>
    <tr style="font-weight:bold;">
      <td>
      </td>
      <td>
      </td>
        <? print buildcol("day","",$selectedmonth,$selectedyear) ?>
      <td>Total
      </td>
    </tr>
    <tr style="font-weight:bold;">
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
        print "<tr style=\"background-color:lightgrey;\">";
        print "<td style=\"vertical-align: top;\">".$ar_agent[1]."</td>";
        print "<td style=\"vertical-align: top;\">HA</td>";
        print buildcol("ha",$ar_agent[0],$selectedmonth,$selectedyear);
        print "<td colspan=\"1\" rowspan=\"2\" style=\"vertical-align: top;\">";
        print "<input type=\"hidden\" id=\"total_".$ar_agent[0]."\" /><span id=\"span_total_".$ar_agent[0]."\" />";
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
</form>
<br>
</body></html>