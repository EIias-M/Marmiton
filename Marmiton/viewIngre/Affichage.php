<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./viewHome/css.css">
	<title> Marmiton </title>
</head>
<body>
	
	<div id="menu">
	<a  class='nom' href='./routeur.php' > Marmiton </a>
	
	<div id="rech">
	
	<form  action = "routeurRecette.php?action=Recherche" method="get">
	 <input  type="hidden" name='action' value="Recherche" >
	 <input class="rech" type='text' name='rech' value="rechercher" >
	 <input type="submit" name="submit" value="recherche">
	</form>
	
	</div>
	
	<div id="incrire">

	<?php
	session_start();
	
		if(isset($_SESSION['user'])){ 
			$tab = $_SESSION['user'];
			$photo = $_SESSION['Photo'];
			echo "<img class=ppmenu src=$photo alt=avatar>";
			echo "<li><a  class='abon' href='routeurUtilisateur.php?action=afficher&id=$tab' > $tab </a></li>";	
			echo "<li><a  class='abon' href='routeurRecette.php?action=create' > Ajouter un recette </a></li>";
			echo "<li><a  class='abon' href='./Inscription/deconnexion.php' > Deconnexion </a></li>";
			if( $_SESSION['Admin'] == 1 ) {
				echo "<li class='abon'> Modérateur </li>";	
			}
			if( $_SESSION['Admin'] == 2 ) {
				echo "<li><a  class='abon' href='routeurUtilisateur.php?action=admin' > Administrateur </a></li>";
			}			
		}else{ echo'<li><a  class="abon" href="./Inscription" > Connexion </a></li>';	}
		
	?>
	</div>
	</div>


	<h1>Liste de tous les Ingrédient</h1>
	
	<?php

		foreach ($lesIngre as $Ingre) {
			echo "<a href='routeurIngre.php?action=AfficherUnIngredient&nomIngredient={$Ingre->getnomIngredient()}'>Ingredient  : {$Ingre->getnomIngredient()} </a></br>"; 
			if(!empty($_SESSION['Admin'])){
				if($_SESSION['Admin']=='2'){
					echo "<a href='routeurIngre.php?action=delete&nomIngredient={$Ingre->getnomIngredient()}'> supprimer l'ingredient </a> | <a href='routeurIngre.php?action=update&nomIngredient={$Ingre->getnomIngredient()}'> modifier l'ingredient </a></p>";
				}
			}    
		}
		echo "<br><br>";
			if(!empty($_SESSION['Admin'])){
				if($_SESSION['Admin']=='2'){
				echo "<a href='routeurIngre.php?action=create'> créer un ingrédient </a>";
				}
			}      
	?>
		<br>
	<a href='./routeur.php'> Retour menu. </a>
</body>
</html>
