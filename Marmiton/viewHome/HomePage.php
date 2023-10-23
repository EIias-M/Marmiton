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

	

	
	<h1> Les recette récentes </h1>

	<form  action = "recette.php" method="post">
	<span> Pour combien de personne :  </span> <br>
	<input  type='text' name='nbr' value="Nombre de personne" > <br>
	<span> Avec qu'elle ingrédients : </span> <br>
	<input  type='text' name='type' value="Ingrédient" > <br>
	<a href="./routeurIngre.php" > Voir les ingrédients </a> <br>
	<span> Avec quelle Ustensile : </span> <br> 
	<input  type='text' name='type' value="Utstensile" > <br>
	<a href="./routeurUstensile.php" > Voir les ustensile </a> <br>
	<span> test : </span> <br> 
	<input  type='text' name='type' value="rechercher" > <br>
	<a href="./routeurCate.php" > Voir les Catégorie </a> <br>
	<input type="submit" name="submit" value="rechercher">
	</form>
	<div id="corps"> 
		<?php


        // affichage de la liste des tâches
		foreach ($lesRecettes as $Recette) {
			$Recette->affichageMenuRecette();
		}

		//echo "<a href='routeurRecette.php?action=create'> créer une Recette </a>";
       

	?>
		
	
	</div>
	
	
	
</body>
</html>