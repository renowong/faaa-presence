<?php

function blue($direction,$date){
    $blue =  "<Row ss:AutoFitHeight=\"0\" ss:Height=\"18.7344\"><Cell ss:MergeAcross=\"5\" ss:StyleID=\"ce1\"><Data ss:Type=\"String\">COMMUNE DE FAA'A</Data></Cell><Cell ss:MergeAcross=\"29\" ss:StyleID=\"ce35\"><Data ss:Type=\"String\">ETAT DE PRESENCE - $date</Data></Cell><Cell ss:Index=\"236\" ss:StyleID=\"ce5\"/></Row><Row ss:AutoFitHeight=\"0\" ss:Height=\"18.7344\"><Cell ss:MergeAcross=\"35\" ss:StyleID=\"ce2\"><Data ss:Type=\"String\">$direction</Data></Cell><Cell ss:Index=\"236\" ss:StyleID=\"ce5\"/></Row><Row ss:AutoFitHeight=\"0\" ss:Height=\"12.7584\"><Cell ss:MergeAcross=\"35\" ss:StyleID=\"ce25\"/></Row>";
    return $blue;
}

?>