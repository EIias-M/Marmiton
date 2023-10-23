<?php
    require_once("./controller/ControllerCommentaire.php");
    $action = "AfficherTous";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerCommentaire"))) 
	    $action = $_GET["action"];
    controllerCommentaire::$action();
?>