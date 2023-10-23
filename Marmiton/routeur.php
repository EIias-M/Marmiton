<?php
	require_once("./controller/ControllerRecette.php");
	//require_once("./viewHome/HomePage.php");
	
	 $action = "home";
    if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods("ControllerRecette"))) 
	    $action = $_GET["action"];
    ControllerRecette::$action();
 ?>