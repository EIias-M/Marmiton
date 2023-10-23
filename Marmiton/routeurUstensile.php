<?php
    require_once("./controller/ControllerUstensile.php");
    $action = "AfficherTous";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerUstensile"))) 
	    $action = $_GET["action"];
    ControllerUstensile::$action();
?>