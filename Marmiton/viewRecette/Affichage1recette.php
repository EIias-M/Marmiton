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


	echo'</div> </div>';


		$laRecette->afficher($Ingredients,$Ustenisles,$Categories);

	echo "<br>";
	if(isset ($_SESSION['user'])){
		$pseudo = $_SESSION['user'];
		$ID=$_GET["recette"];
		$check =Connexion::pdo()->prepare('SELECT pseudo FROM Commentaires WHERE pseudo= :tag_pseudo AND ID = :tag_ID;');
		$valeurs = array(":tag_pseudo" => $pseudo, ":tag_ID"=> $ID);
		$check->execute($valeurs);
        $data = $check->fetch();
        $row = $check->rowCount();
		
		if($row==0){
			echo "<form action=routeurCommentaire.php method=get>";
			echo  "<input type=hidden name=action value=created>";
			
			echo " <input type=hidden name=ID value=$_GET[recette] > ";
			echo " <input type=hidden name=pseudo value=$_SESSION[user]>" ;
			echo "<p>
			<label>Commentaire : </label>
			<input type=texte name=texte required>
			<label>Note  : </label>
			<input type=texte name=note required>
			<input type=submit name=envoyer value=Poster>";
			echo "</p>";

			echo'</form>';
	
			echo'<br><br><br><br>';
		}
		else { 
			echo "<p>Vous avez deja ecrit un commentaire a propos de cette recette<p><br>";
		}
	
		if( $pseudo  ==$_SESSION['user'] or $_SESSION['Admin']>0 ) {
			echo "<a href='routeurRecette.php?action=delete&ID={$ID}'> supprimer la Recette </a>";
		}
	
	}
	
	echo "<h3>Commentaire : </h3><br>";
	
	
	
	
	if ($CommentairesUtilisateur != null ) {
		
		foreach ($CommentairesUtilisateur as $com) {
		
			$com->CommentaireUtilisateur();
			$log = $com->getLogin();
		

			if( (isset ($_SESSION['user'])) && ($log  ==$_SESSION['user'] or $_SESSION['Admin']>0 )) {

				echo "<a href='routeurCommentaire.php?action=delete&IDRecette={$ID}&&pseudo={$log}'> supprimer le com</a>";
			}

		
		}
	}

	
			
	
	?>
	
	<a href='./routeur.php'> Retour menu. </a>
</body>
</html>
