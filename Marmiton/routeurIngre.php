<?php
    require_once("./controller/ControllerIngredient.php");
    $action = "AfficherTous";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerIngredient"))) 
	    $action = $_GET["action"];
    controllerIngredient::$action();
?>