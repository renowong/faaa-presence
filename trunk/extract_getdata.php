<?php
function getdata($year,$month,$agentids) {
	$agentid = explode("|",$agentids);

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
            $output .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"29.988\"><Cell ss:StyleID=\"ce7\"><Data ss:Type=\"String\">CHAN</Data></Cell><Cell ss:StyleID=\"ce19\"><Data ss:Type=\"String\">HA</Data></Cell>";
            for($i=1;$i<=31;$i++){
                $output .= "<Cell ss:StyleID=\"ce28\" id=\"ha_".$id."_".$i."\"><Data ss:Type=\"String\">".$arr["ha_".$id."_".$i]."</Data></Cell>";
            }
            $output .= "<Cell ss:StyleID=\"ce51\"/><Cell ss:StyleID=\"ce58\"/><Cell ss:StyleID=\"ce58\"/><Cell ss:StyleID=\"Default\"/></Row>";
            $output .= "<Row ss:AutoFitHeight=\"0\" ss:Height=\"29.988\"><Cell ss:StyleID=\"ce8\"><Data ss:Type=\"String\">Eric</Data></Cell><Cell ss:StyleID=\"ce19\"><Data ss:Type=\"String\">HD</Data></Cell>";
            for($i=1;$i<=31;$i++){
                $output .= "<Cell ss:StyleID=\"ce28\" id=\"hd_".$id."_".$i."\"><Data ss:Type=\"String\">".$arr["hd_".$id."_".$i]."</Data></Cell>";
            }
            $output .= "<Cell ss:StyleID=\"ce51\"/><Cell ss:StyleID=\"ce58\"/><Cell ss:StyleID=\"ce58\"/><Cell ss:StyleID=\"Default\"/></Row>";
            
        }
        
        return $output;
}

?>