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


	<form action="routeur.php" method="get">
		<input type="hidden" name="action" value="updated">
		<p>
			<label>numTache:</label>
			<input type="text" name="ID" value="<?php echo $comm->getIDnumTache(); ?>" readonly>
		</p>
		<p>
			<label>libelle :</label>
			<input type="text" name="pseudo" value="<?php echo $comm->getLogin(); ?>" readonly>
		</p>
		<p>
			<label>Entrez un nouveau commentaire :</label>
			<input type="text" name="texte" value="" required>
		</p>
        <p>
			<label>dateButoir :</label>
			<input type="text" name="note" value="<?php echo $comm->getNote(); ?>" required>
		</p>
		<p>
			<input type="submit" name="envoyer" value="modifier la voiture">
		</p>
	</form>
</body>
</html>