<?php

$maxdays = $_GET['maxdays'];

$days = "<Row ss:AutoFitHeight=\"0\" ss:Height=\"16.4952\"><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce4\"><Data ss:Type=\"String\">NOM Prénom</Data></Cell><Cell ss:StyleID=\"ce16\"/>";

for ($i=1;$i<=$maxdays;$i++){
    $days .= "<Cell ss:StyleID=\"ce26\"><Data ss:Type=\"String\">J</Data></Cell>";
}

$days .="<Cell ss:MergeDown=\"1\" ss:StyleID=\"ce49\"><Data ss:Type=\"String\">TOTAL Heure de travail</Data></Cell><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce57\"><Data ss:Type=\"String\">BULLETIN
PAIE</Data></Cell><Cell ss:MergeDown=\"1\" ss:StyleID=\"ce64\"><Data ss:Type=\"String\">PRESENCE</Data></Cell><Cell ss:Index=\"236\" ss:StyleID=\"ce5\"/></Row>";

$days .= "<Row ss:Height=\"25\"><Cell ss:Index=\"3\" ss:StyleID=\"ce26\"><Data ss:Type=\"Number\">1</Data></Cell>";

for ($i=2;$i<=$maxdays;$i++){
    $days .= "<Cell ss:StyleID=\"ce26\"><Data ss:Type=\"Number\">$i</Data></Cell>";
}

$days .="</Row>";

$days .="<Row ss:AutoFitHeight=\"0\" ss:Height=\"28.4904\"><Cell ss:MergeAcross=\"".($maxdays+4)."\" ss:StyleID=\"ce6\"><Data ss:Type=\"String\">".$_GET['svc']."</Data></Cell></Row>";

?>