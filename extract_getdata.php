<?php
function getdata($year,$month,$agentids) {
	$agentid = explode("|",$agentids);
        $maxdays = $_GET["maxdays"];
	$firstday = date("w",mktime(0,0,0,$month,1,$year));

	$mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
	////set the query
        $arr = array();
        foreach($agentid as &$id){
            for($i=1;$i<=31;$i++){
                $arr["ha_".$id."_".$i]="";
            }
            for($i=1;$i<=31;$i++){
                $arr["hd_".$id."_".$i]="";
            }
            
        }
        
        
        foreach($agentid as &$id){
            $query = sprintf("SELECT * FROM `presence` WHERE `year`='%s' AND `month`='%s' AND `agentid`='%s' ORDER BY `type`,`agentid`,ABS(`day`)",$year,$month,$id);
            $result = $mysqli->query($query);
                    if ($result){
                        while($row = $result->fetch_object()){
                        $idtag = $row->type."_".$row->agentid."_".$row->day;
                        $arr[$idtag] = $row->value;
                        //$xml .= "<data idtag='$idtag'>".$row->value."</data>";
                        }
                    } else {
                        echo $mysqli->error;
                    }
            $result->close();
        }
        


        $mysqli->close(); 
        
        //print_r($arr);
        
	
        foreach($agentid as &$id){
	    $j = $firstday;
            $tt = $_GET[$id];
            $ar_agent = getname($id);
            $output .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"29.988\"><Cell ss:StyleID=\"ce7\"><Data ss:Type=\"String\">".$ar_agent[0]."</Data></Cell><Cell ss:StyleID=\"ce19\"><Data ss:Type=\"String\">HA</Data></Cell>";
            for($i=1;$i<=$maxdays;$i++){
		if($j==0||$j==6){$style="ce6";}else{$style="ce28";}
                $output .= "<Cell ss:StyleID=\"$style\" id=\"ha_".$id."_".$i."\"><Data ss:Type=\"String\">".$arr["ha_".$id."_".$i]."</Data></Cell>";
		if($j==6){$j=0;}else{$j++;}
	    }
            $output .= "<Cell ss:StyleID=\"ce51\" ss:MergeDown=\"1\"><Data ss:Type=\"String\">$tt</Data></Cell><Cell ss:StyleID=\"ce58\" ss:MergeDown=\"1\" /><Cell ss:StyleID=\"ce58\" ss:MergeDown=\"1\" /></Row>";
            $output .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"29.988\"><Cell ss:StyleID=\"ce8\"><Data ss:Type=\"String\">".$ar_agent[1]."</Data></Cell><Cell ss:StyleID=\"ce19\"><Data ss:Type=\"String\">HD</Data></Cell>";
            $j = $firstday;
	    for($i=1;$i<=$maxdays;$i++){
		if($j==0||$j==6){$style="ce6";}else{$style="ce28";}
                $output .= "<Cell ss:StyleID=\"$style\" id=\"hd_".$id."_".$i."\"><Data ss:Type=\"String\">".$arr["hd_".$id."_".$i]."</Data></Cell>";
		if($j==6){$j=0;}else{$j++;}
	    }
            $output .= "</Row>";
            
        }
        
        return $output;
}

function getname($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $query = sprintf("SELECT `nom`,`prenom` FROM `agents` WHERE `agentid`='%s'",$id);
    $result = $mysqli->query($query);
    $row = $result->fetch_object();
    $ar_agent = array($row->nom,$row->prenom);
    return $ar_agent;
}

?>