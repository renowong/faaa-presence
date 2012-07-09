<?php

function blue($direction,$date){
$maxdays = $_GET['maxdays'];
$coladjust = $maxdays-24;

$partofhead = "<Column ss:Span=\"$coladjust\" ss:Width=\"29.2536\"/>".
            "<Column ss:Width=\"32.256\"/>".
            "<Column ss:Width=\"61.5096\"/>".
            "<Column ss:Width=\"74.2392\"/>".
            "<Column ss:Width=\"78.012\"/>".
            "<Column ss:Span=\"201\" ss:Width=\"60.012\"/>";
            
    $blue =  $partofhead."<Row ss:AutoFitHeight=\"0\" ss:Height=\"18.7344\"><Cell ss:MergeAcross=\"5\" ss:StyleID=\"ce1\"><Data ss:Type=\"String\">COMMUNE DE FAA'A</Data></Cell><Cell ss:MergeAcross=\"".($maxdays-2)."\" ss:StyleID=\"ce35\"><Data ss:Type=\"String\">ETAT DE PRESENCE - $date</Data></Cell></Row>".
    "<Row ss:AutoFitHeight=\"0\" ss:Height=\"18.7344\"><Cell ss:MergeAcross=\"".($maxdays+4)."\" ss:StyleID=\"ce2\"><Data ss:Type=\"String\">$direction</Data></Cell><Cell ss:Index=\"236\" ss:StyleID=\"ce5\"/></Row>".
    "<Row ss:AutoFitHeight=\"0\" ss:Height=\"12.7584\"><Cell ss:MergeAcross=\"".($maxdays+4)."\" ss:StyleID=\"ce2\"/></Row>";
    return $blue;
}

?>