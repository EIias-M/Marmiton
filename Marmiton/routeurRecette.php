<?php
    require_once("./controller/ControllerRecette.php");
    $action = "AfficherTous";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerRecette"))) 
	    $action = $_GET["action"];
    ControllerRecette::$action();
	
	
	

?>