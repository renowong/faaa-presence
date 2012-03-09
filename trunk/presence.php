<?php
include_once('config.php');
if($_GET["load"]){
    $selectedmonth = $_GET["month"];
    $selectedyear = $_GET["year"]; 
}else{
    $selectedmonth = date("m");
    $selectedyear = date("Y"); 
}

$ar_agents = getagents();
$months = buildmonths($selectedmonth);
$years = buildyears($selectedyear);

function buildmonths($s){
    $ar_month = array(1=>'Janvier',2=>'F&eacute;vrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Ao&ucirc;t',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'D&eacute;cembre');
    for ($i=1;$i<=12;$i++){
        if($s==$i){$select=" selected";}else{$select="";}
        $output .= "<option value=\"".$i."\"$select>".$ar_month[$i]."</option>";
    }
    //$output = print_r($ar_month);
    return $output;
}

function buildyears($s){
    $ar_year = array(2012=>'2012',2013=>'2013',2014=>'2014');
    for ($i=2012;$i<=2014;$i++){
        if($s==$i){$select=" selected";}else{$select="";}
        $output .= "<option value=\"".$i."\"$select>".$ar_year[$i]."</option>";
    }
    //$output = print_r($ar_month);
    return $output;
}

function getagents($svc){
        $ar_agent = array();
    	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
	$query = sprintf("SELECT * FROM `agents` WHERE `service`='%s'","INF");
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        array_push($ar_agent,array($row->agentid,$row->nom,$row->prenom));            
        }
        $mysqli->close();
        
        return $ar_agent;
}

function buildcol($input,$id,$month,$year){
    $max = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i=1; $i<=$max; $i++)
    {
        switch ($input){
            case "num":
                print "<td>$i</td>";
            break;
            case "hd":
                print "<td>";
                if(!WE($i,$month,$year)) print "<input type=\"text\" size=\"2\" maxlength=\"5\" id=\"hd_".$id."_".$i."\" />";
                print "</td>";
            break;
            case "ha":
                print "<td>";
                if(!WE($i,$month,$year)) print "<input type=\"text\" size=\"2\" maxlength=\"5\" id=\"ha_".$id."_".$i."\" />";
                print "</td>";
            break;
        }
    }
}

function WE($day,$month,$year){
    $lday = date("l", mktime(0, 0, 0, $month, $day, $year));
    if($lday=="Saturday" || $lday=="Sunday"){
        return true;
    }else{
        return false;
    }
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title></title>
    <style type="text/css">@import url("css/main.css");</style>
        <!-- jquery -->
        <script type="application/x-javascript" src="js/jquery-1.7.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
        
        });
        
        function loaddate(){
            var month = $("#slt_month").val();
            var year = $("#slt_annee").val();
            window.location = "presence.php?load=true&month="+month+"&year="+year;
        }
    </script>
</head><body>
<input type="hidden" id="editmonth" value="<? print $selectedmonth; ?>"/>
<input type="hidden" id="edityear" value="<? print $selectedyear; ?>"/>
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