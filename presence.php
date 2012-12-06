<?php
include_once('config.php');
include_once('headers.php');
include_once('presence_top.php');
include_once('menu.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<link rel='stylesheet' type='text/css' href='css/cssreset.css' />
    <?php echo $title.$icon.$charset.$nocache.$cssreset.$defaultcss.$jquery.$jqueryui.$message_div.$menucss.$graburljs ?>
        <!-- jquery -->
        <script type="text/javascript">
        $(document).ready(function () {
        //alert(document.cookie);
        //load data
        var ids = $("#agentsids").val();
        var ar_ids = ids.split("|");
        for(i=0;i<ar_ids.length;i++){
            getdata($("#editmonth").val(),$("#edityear").val(),ar_ids[i]);
        }
        
        loadferies($("#editmonth").val(),$("#edityear").val());
        $( "input:submit, button" ).button();
        });
        
        
        
        function getdata(month,year,agentid){
            $.post("getdata.php", {month:month,year:year,agentid:agentid},
                function(response) {
                loaddata(response);
                });
            
        }
        
        function loadferies(month,year){
            $.post("getferies.php", {month:month,year:year},
                function(response) {
                var feries = $.parseJSON(response);
                $.each(feries,function(i,elem){
                    if(elem.substring(0,1)=="0") {elem = elem.replace("0","");}
                   $('input[id^=ha_][id$=_'+elem+']').val('F').blur();
                   $('input[id^=ha_][id$=_'+elem+']').prop('readonly','readonly');
                   $('input[id^=ha_][id$=_'+elem+']').addClass('grey');
                   $('input[id^=hd_][id$=_'+elem+']').val('F').blur();
                   $('input[id^=hd_][id$=_'+elem+']').prop('readonly','readonly');
                   $('input[id^=hd_][id$=_'+elem+']').addClass('grey');
                });
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
            var showall = gup('showall');
            window.location = "presence.php?load=true&month="+month+"&year="+year+"&showall="+showall;
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
            
            var ffvalue = fvalue.substring(0,1);
            var pattern = /^[2-9]$/;
            if(pattern.test(ffvalue)){fvalue="0"+fvalue;$("#"+fname).val(fvalue);}
            
            //alert(fname.substring(1));
            //if(fvalue!=""){
                if(checkvalid(fvalue) && checksequence(fname)){
                    //$("#"+fname).prop("readonly","readonly");
                    $.post("update.php", {year:edityear,month:editmonth,day:editday,type:type,value:fvalue,agentid:agentid},
                            function(response) {
                                //readresponse(response);
                               //alert(response);
                                //$("#"+fname).prop("readonly","");
                            });
                }else{
                    message("Entr\351e invalide!");
                    $("#"+fname).val("");
                }                
            //}
        }
        
        function checksequence(h){
            var f_ha = "ha"+h.substring(2);
            var f_hd = "hd"+h.substring(2);
            var ha = $("#"+f_ha).val();
            var hd = $("#"+f_hd).val();
            //alert(hd);            
            if(ha.length<=2 || hd.length<=2){
                return true;
            }else{
                var ar_ha = ha.split(":");
                var ar_hd = hd.split(":");
                var num_a = ar_ha[0]*1;
                var num_d = ar_hd[0]*1;
                if(num_a<=num_d){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        function checkvalid(input){
            var pattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            var pattern2 = /^(CP|AB|AM|CM|AT|CF|FO|F)?$/i;
            if(pattern.test(input) || pattern2.test(input)){
                return true;
            }else{
                return false;
            }
        }
        
        function calc(field){
            var pattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            var pattern2 = /^(CP|AM|CM|AT|CF|FO)$/i;
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
                if(!pattern.test(ha)||!pattern.test(hd)){ha="";hd="";}
            }
            
            var tt = new Date('01/01/2009 ' + hd)-new Date('01/01/2009 ' + ha);
            tt = tt/1000; //convert to seconds
            $("#tt"+suffix).val(tt);
            total(suffix);
        }
        
        function inputdots(field){
            //alert(field.value.length);
            if(field.value.length == 2 && !isNaN(field.value)) {field.value = field.value+":";}
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
        
        function showall(val){
            if(val) {
                window.location='presence.php?showall=1';
            }else{
                window.location='presence.php';
            }
        }
    </script>
</head>
<body>
<div name="message" id="message" ></div>
<? print $menu ?>
<input type="hidden" id="editmonth" value="<? print $selectedmonth; ?>"/>
<input type="hidden" id="edityear" value="<? print $selectedyear; ?>"/>
<input type="hidden" id="agentsids" value="<? print $agentsids; ?>"/>
<input type="hidden" id="svc" value="<? print $service; ?>"/>
<input type="hidden" id="maxdays" value="<? print cal_days_in_month(CAL_GREGORIAN, $selectedmonth, $selectedyear); ?>"/>
<div id="presence_selector" name="presence_selector">
    <button onclick="window.location='presence.php';">Mois en cours</button> <button onclick="extract();">Excel</button>
    <?
    if($isdir=="true"){
        print "| <input type=\"checkbox\" id=\"showall\" name=\"showall\" onchange=\"showall(this.checked);\"$showall /> Afficher les services";
    }
    ?>
    <br/><br/>
    <p>Mois : <select id="slt_month">
        <? print $months ?>
    </select>
    Ann&eacute;e :
    <select id="slt_annee">
        <? print $years ?>
    </select>
    <button onclick="loaddate();">Charger</button>
    </p>
</div>
<div class="div_presence">
<table class="tbl_presence">
    <th colspan="35">Tableau des pr&eacute;sences</th>
  <tbody class="td_presence">
    <tr style="font-weight:bold;">
      <td colspan="2">
      </td>
        <? print buildcol("day","",$selectedmonth,$selectedyear) ?>
      <td rowspan="2" class="td_presence">Total
      </td>
    </tr>
    <tr style="font-weight:bold;">
      <td class="td_names staticcol" style="background-color:lightyellow;">Agent
      </td>
      <td class="td_names">HA/HD
      </td>
        <? print buildcol("num","",$selectedmonth,$selectedyear) ?>
    </tr>
    <?
    foreach ($ar_agents as &$ar_agent){
        print "<tr style=\"background-color:lightgrey;\" title=\"".$ar_agent[1]." ".$ar_agent[2]." HA\">";
        print "<td class=\"td_names staticcol\" style=\"background-color:lightgrey;\">".$ar_agent[1]."</td>";
        print "<td class=\"td_names\">HA</td>";
        print buildcol("ha",$ar_agent[0],$selectedmonth,$selectedyear,$ar_agent[1],$ar_agent[2]);
        print "<td colspan=\"1\" rowspan=\"2\" style=\"vertical-align: middle;\">";
        print "<input type=\"hidden\" id=\"total_".$ar_agent[0]."\" /><span id=\"span_total_".$ar_agent[0]."\" style=\"font-weight:bold;\"/>";
        print "</td></tr>";
        print "<tr title=\"".$ar_agent[1]." ".$ar_agent[2]." HD\">";
        print "<td class=\"td_names staticcol\" style=\"background-color:lightyellow;\">".$ar_agent[2]."</td>";
        print "<td class=\"td_names\">HD</td>";
        print "</td>";
        print buildcol("hd",$ar_agent[0],$selectedmonth,$selectedyear,$ar_agent[1],$ar_agent[2]);
        print "</tr>";
    }
    ?>
  </tbody>
</table>
</div>
<br>
    <table>
            <th colspan="2" style="border-right:solid 2px black;">
                Valeurs autoris&eacute;es
            </th>
            <th>
                L&eacute;gende
            </th>
        <tr>
            <td style="padding:10px;">
                AB : Absence<br/>
                CP : Cong&eacute;s pay&eacute;s<br/>
                AM : Arr&ecirc;t maladie<br/>
                CM : Cong&eacute;s maternit&eacute;<br/>
            </td>
            <td style="padding:10px;">
                AT : Accident de travail<br/>
                CF : Cong&eacute;s pour &eacute;v&eacute;nements familiaux<br/>
                FO : Formation
            </td>
            <td style="padding:10px;">
                HA : Heure d'arriv&eacute;e<br/>
                HD : Heure de d&eacute;part
            </td>
        </tr>
    </table>
</body></html>