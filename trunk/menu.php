<?php

$isadmin = $_COOKIE['isadmin'];
$menu="<div class=\"horizontalcssmenu\">".
"<ul id=\"cssmenu1\">".
"<li style=\"border-left: 1px solid #202020;\"><a href=\"index.php?logout=1\">Quitter</a></li>".
"<li><a href=\"presence.php\" >Pr&eacute;sences</a></li>";
if($isadmin){
    $menu.="<li><a href=\"agents.php\" >Gestion des Agents</a></li>".
    "<li><a href=\"ferie.php\" >Gestion des F&eacute;ri&eacute;s</a></li>".
    "<li><a href=\"admins.php\" >Gestion des Acc&egrave;s</a></li>";
}
$menu.="<br style=\"clear: left;\" /><br/>".
"</div>";

### Example ###
//$menu="<div class=\"horizontalcssmenu\">".
//"<ul id=\"cssmenu1\">".
//"<li style=\"border-left: 1px solid #202020;\"><a href=\"http://www.javascriptkit.com/\">Home</a></li>".
//"<li><a href=\"http://www.javascriptkit.com/cutpastejava.shtml\" >Free JS</a></li>".
//"<li><a href=\"http://www.javascriptkit.com/\">JS Tutorials</a></li>".
//"<li><a href=\"#\">References</a>".
//"    <ul>".
//"    <li><a href=\"http://www.javascriptkit.com/jsref/\">JS Reference</a></li>".
//"    <li><a href=\"http://www.javascriptkit.com/domref/\">DOM Reference</a></li>".
//"    <li><a href=\"http://www.javascriptkit.com/dhtmltutors/cssreference.shtml\">CSS Reference</a></li>".
//"    </ul>".
//"</li>".
//"<li><a href=\"http://www.javascriptkit.com/howto/\">web Tutorials</a></li>".
//"<li><a href=\"#\">Resources</a>".
//"    <ul>".
//"    <li><a href=\"http://www.dynamicdrive.com\">Dynamic HTML</a></li>".
//"    <li><a href=\"http://www.codingforums.com\">Coding Forums</a></li>".
//"    <li><a href=\"http://www.cssdrive.com\">CSS Drive</a></li>".
//"    <li><a href=\"http://www.dynamicdrive.com/style/\">CSS Library</a></li>".
//"    <li><a href=\"http://tools.dynamicdrive.com/imageoptimizer/\">Image Optimizer</a></li>".
//"    <li><a href=\"http://tools.dynamicdrive.com/favicon/\">Favicon Generator</a></li>".
//"    </ul>".
//"</li>".
//"</ul>".
//"<br style=\"clear: left;\" /><br/>".
//"</div>";

?>
