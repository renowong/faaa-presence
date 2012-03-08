<?php
include_once('config.php');
$ar_agents = getagents();

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

function buildcol($input,$id){
    $thisyear = date("Y");
    $thismonth = date("m");
    $max = cal_days_in_month(CAL_GREGORIAN, $thismonth, $thisyear);
    for ($i=1; $i<=$max; $i++)
    {
        switch ($input){
            case "num":
                print "<td style=\"vertical-align: top;\">$i</td>";
            break;
            case "hd":
                print "<td style=\"vertical-align: top;\">".
                "<input type=\"text\" size=\"5\" maxlength=\"5\" id=\"hd_".$id."_".$i."\" />".
                "</td>";
            break;
            case "ha":
                print "<td style=\"vertical-align: top;\">".
                "<input type=\"text\" size=\"5\" maxlength=\"5\" id=\"ha_".$id."_".$i."\" />".
                "</td>";
            break;
        }
    }
}

function checkWE($day,$month,$year){
    
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title></title></head><body>
<table style="text-align: left; width: 100%;" border="1" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="vertical-align: top;">Agent
      </td>
      <td style="vertical-align: top;">HA/HD
      </td>
        <? print buildcol("num") ?>
      <td style="vertical-align: top;">Total
      </td>
    </tr>
    <?
    foreach ($ar_agents as &$ar_agent){
        print "<tr>";
        print "<td style=\"vertical-align: top;\">".$ar_agent[1]."</td>";
        print "<td style=\"vertical-align: top;\">HA</td>";
        print buildcol("ha",$ar_agent[0]);
        print "<td colspan=\"1\" rowspan=\"2\" style=\"vertical-align: top;\">";
        print "<span id=\"total_".$ar_agent[0]."\" />";
        print "</td></tr>";
        print "<tr>";
        print "<td style=\"vertical-align: top;\">".$ar_agent[2]."</td>";
        print "<td style=\"vertical-align: top;\">HD</td>";
        print "</td>";
        print buildcol("hd",$ar_agent[0]);
        print "</tr>";
    }
    ?>
  </tbody>
</table>
<br>
</body></html>