<?php
    require_once("./controller/ControllerUtilisateur.php");
    $action = "default";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerUtilisateur"))) 
	    $action = $_GET["action"];
    controllerUtilisateur::$action();
?>