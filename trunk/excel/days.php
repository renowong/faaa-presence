<?php

$maxdays = $_GET['maxdays'];
$ar_days = array("D","L","M","M","J","V","S");

$firstday = date("w",mktime(0,0,0,$_GET['month'],1,$_GET['year']));

$days = "<Row ss:AutoFitHeight=\"0\" ss:Height=\"16.4952\"><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce4\"><Data ss:Type=\"String\">NOM Prénom</Data></Cell><Cell ss:StyleID=\"ce49\"/>";

$j = $firstday;

for ($i=1;$i<=$maxdays;$i++){
    if($j==0||$j==6){$style="ce6";}else{$style="ce49";}
    $days .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"String\">".$ar_days[$j]."</Data></Cell>";
    if($j==6){$j=0;}else{$j++;}
}

$days .="<Cell ss:MergeDown=\"1\" ss:StyleID=\"ce49\"><Data ss:Type=\"String\">TOTAL Heure de travail</Data></Cell><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce57\"><Data ss:Type=\"String\">BULLETIN
PAIE</Data></Cell><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce64\"><Data ss:Type=\"String\">PRESENCE</Data></Cell><Cell ss:Index=\"236\" ss:StyleID=\"ce5\"/></Row>";

$days .= "<Row ss:Height=\"25\"><Cell ss:Index=\"2\" ss:StyleID=\"ce26\"/>";

$j = $firstday;
for ($i=1;$i<=$maxdays;$i++){
    if($j==0||$j==6){$style="ce6";}else{$style="ce26";}
    $days .= "<Cell ss:StyleID=\"$style\"><Data ss:Type=\"Number\">$i</Data></Cell>";
    if($j==6){$j=0;}else{$j++;}
}

$days .="</Row>";

$days .="<Row ss:AutoFitHeight=\"0\" ss:Height=\"28.4904\"><Cell ss:MergeAcross=\"".($maxdays+4)."\" ss:StyleID=\"ce6\"><Data ss:Type=\"String\">".$_GET['svc']."</Data></Cell></Row>";

?>