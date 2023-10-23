<?php
    require_once("./controller/ControllerCategorie.php");
    $action = "AfficherTous";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerCategorie"))) 
	    $action = $_GET["action"];
    controllerCategorie::$action();
?>