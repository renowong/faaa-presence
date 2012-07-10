<?php
if($_COOKIE['user']==''){header("Location: index.php");}

if($_GET["load"]){
    $selectedmonth = $_GET["month"];
    $selectedyear = $_GET["year"]; 
}else{
    $selectedmonth = date("m");
    $selectedyear = date("Y"); 
}

$service = $_COOKIE['svc'];
$ar_agents = getagents($service);
$months = buildmonths($selectedmonth);
$years = buildyears($selectedyear);
$agentsids = buildagentsids($ar_agents);
if($_GET['showall']==1) $showall = " checked";
if(strpos($service,"/")=="") {$isdir="true";}else{$isdir="false";};


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
        if($i<10) {$j = "0".$i;}else{$j=$i;}
        $output .= "<option value=\"".$j."\"$select>".$ar_month[$i]."</option>";
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
	if($_GET['showall']==1){
	    $query = sprintf("SELECT * FROM `agents` WHERE `service` LIKE '%s%%' AND `active`='1' ORDER BY service,nom",$svc);
	}else{
	    $query = sprintf("SELECT * FROM `agents` WHERE `service` LIKE '%s' AND `active`='1' ORDER BY service,nom",$svc);
	}
	
	$result = $mysqli->query($query);
        while($row = $result->fetch_object()){
        array_push($ar_agent,array($row->agentid,$row->nom,$row->prenom));            
        }
        $mysqli->close();
        
        return $ar_agent;
}

function buildcol($input,$id,$month,$year,$prenom,$nom){
    $max = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $today = date("Y-m-d");
    //print strtotime($today)."<-//->".mktime(0, 0, 0, $month, 21, $year)."$$$";
    for ($i=1; $i<=$max; $i++)
    {
	if(strtotime($today)==mktime(0, 0, 0, $month, $i, $year)){$green="background-color:green;";}else{$green="";}
	$we = date("N",mktime(0, 0, 0, $month, $i, $year));
	if($we==6||$we==7){$grey="background-color:grey;";}else{$grey="";}
        switch ($input){
	    case "num":
                print "<td class=\"td_presence\" style=\"$green$grey\">$i</td>";
            break;  
            case "day":
		$ar_days = array("L","M","M","J","V","S","D");
		$j = date("N", mktime(0, 0, 0, $month, $i, $year))-1;
		print "<td  class=\"td_presence\" style=\"$green$grey\">".$ar_days[$j]."</td>";
            break;
            case "hd":
                print "<td  class=\"td_presence\" style=\"$green$grey\">";
                if(!WE($i,$month,$year)) print "<input type=\"text\" class=\"uppercase\" size=\"4\" maxlength=\"5\" name=\"hd_".$id."_".$i."\" id=\"hd_".$id."_".$i."\" onBlur=\"update(this);calc(this.name);\" title=\"".$prenom." ".$nom." HD\" />";
                print "</td>";
            break;
            case "ha":
                print "<td  class=\"td_presence\" style=\"$green$grey\">";
                if(!WE($i,$month,$year)) print "<input type=\"hidden\" name=\"tt_".$id."_".$i."\" id=\"tt_".$id."_".$i."\"><input type=\"text\" class=\"uppercase\" size=\"4\" maxlength=\"5\" name=\"ha_".$id."_".$i."\" id=\"ha_".$id."_".$i."\" onBlur=\"update(this);calc(this.name);\" title=\"".$prenom." ".$nom." HA\" />";
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