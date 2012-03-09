<?php

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
$agentsids = buildagentsids($ar_agents);


///////////////functions*//////////////////////

function buildagentsids($arr){
    foreach ($arr as &$id) {
    $ids .= $id[0]."|";
    }
    $ids = substr($ids,0,-1);
    return $ids;
}

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
                if(!WE($i,$month,$year)) print "<input type=\"text\" size=\"2\" maxlength=\"5\" name=\"hd_".$id."_".$i."\" id=\"hd_".$id."_".$i."\" onBlur=\"update(this);\" />";
                print "</td>";
            break;
            case "ha":
                print "<td>";
                if(!WE($i,$month,$year)) print "<input type=\"text\" size=\"2\" maxlength=\"5\" name=\"ha_".$id."_".$i."\" id=\"ha_".$id."_".$i."\" onBlur=\"update(this);\" />";
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