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

<h1> modification de la recette </h1>

	<form action="routeurRecette.php" method="get">
		<input type="hidden" name="action" value="updated">
		
		<p>
			<label>Auteur :</label>
			<?php

			session_start();
			$login = $_SESSION["user"];

			echo "<input type='text' name='Pseudo' value=$login readonly>";
		
			?>
		</p>
		
		<p>
			<label>Nom de la Recette :</label>
			<input type="text" name="Nom" value=<?php echo $laRecette->getNom() ?> readonly>
		</p>
		<p>
			<label>Pour combien de personne :</label>
			<input type="text" name="NbPersonnes" value=<?php echo $laRecette->getNbPersonnes() ?> required>
		</p>
		<p>
			<label>Temps de préparation ( en min )  :</label>
			<input type="text" name="TempsDePreparation" value=<?php echo $laRecette->getTempsDePreparation() ?> required>
		</p>
		<p>
			<label>La recette :</label>
			<input type="text" name="Description" value=<?php echo $laRecette->getDescription() ?> required>
		</p>
		<p>
			<label>Chemin jusqu'a la photo :</label>
			<input type="text" name="Photo" value=<?php echo $laRecette->getPhoto() ?> >
		</p>
		<p>
			<label>Niveau de Difficultée:</label>
			<select name="NiveauDeDifficulter" id="cars">
				<option value=0>Facile</option>
				<option value=1 selected>Intermédiaire</option>
				<option value=2>Dur</option>
</select>


			
			<!--<input type="text" name="NiveauDeDifficulter" required> 
				A vérifier que le select envoie bien le cookie !!! -->
		</p>
			<h2> Ingrédient </h2>
			<div id="nouveau_input"></div>
			<input type="button"onclick="nouveauInput()"  value="+">

	
			<script>
			var n = 0; 
			var contenu = ""
			function nouveauInput(){
				n = n + 1;
				<!-- requête de php pour récupérer tout les igrédient puis les transformer en option valeur ... -->
				//contenu = contenu +"<span> Ingrédient :</span>" +  "<select>";
				contenu =contenu + "</select><label for='Ingrédient" + n + "'>Ingrédient "+ n  +  "<select name= ingredient"+ n + ">" ;
				<?php 

				foreach($Lesingrédient as $ingrédient ) {
				echo 'contenu = contenu + "<option value=' .$ingrédient->getnomIngredient(). '>' . $ingrédient->getnomIngredient(). '</option>";';	
				}
				
			
				
				?>
				
				contenu = contenu + "</select><label for='qtq" + n + "'>qtq "+ n +" <input type='text' name='qtq" + n + "' />";
				contenu = contenu + "<label for='UniterdeMesure" + n + "'>Uniter de Mesure "+ n +" <input type='text' name='Mesure" + n + "' /><br />";
				document.getElementById('nouveau_input').innerHTML = contenu;
				
}
			</script>
			
			
			<h2> Ustensile </h2>
			<div id="nouveau_inputUstenisle"></div>
			<input type="button"onclick="nouveauInputUstenisle()"  value="+">
	
			<script>
			var i = 0; 
			var contenu2 = ""
			function nouveauInputUstenisle(){
				i = i + 1;
				
				contenu2 = contenu2 + "</select><label for='Ustensile" + i + "'>Ustensile "+ i  +  "<select name= Ustensile"+ i + ">" ;

				<!-- requête de php pour récupérer tout les Ustensile puis les transformer en option valeur ... -->
					<?php 

				foreach($Lesustensiles as $ustensile ) {
				echo 'contenu2 = contenu2 + "<option value=' .$ustensile->getnomUstensile(). '>' . $ustensile->getnomUstensile(). '</option>";';	
				}
				
			
				
				?>
				contenu2 = contenu2 + "</select> <label for='Quantite" + i + "'>Quantite "+ i +" <input type='text' name='Quantite" + i + "' /><br />";
				document.getElementById('nouveau_inputUstenisle').innerHTML = contenu2;
				
			}
			</script>
			
			<h2> Catégories </h2>
			<div id="nouveau_inputCatégories"></div>
			<input type="button"onclick="nouveauInputCatégories()"  value="+">
	
			<script>
			var j = 0; 
			var contenu3 = ""
			function nouveauInputCatégories(){
				j = j + 1;
				
				contenu3 = contenu3 + "</select><label for='Categories" + j + "'>Categories "+ j  +  "<select name= Categories"+ j + ">" ;
				<?php 

				foreach($LesCatégories as $Catégories ) {
				echo 'contenu3 = contenu3 + "<option value=' .$Catégories->getNomCategorie(). '>' . $Catégories->getNomCategorie(). '</option>";';	
				}
				
			
				
				?>
				contenu3= contenu3+ "</select> <br>";
				document.getElementById('nouveau_inputCatégories').innerHTML = contenu3;
				
			}
			</script>
			
		<p>
		
		
		
			<input type="submit" name="envoyer" value="modifier la Recette">
		</p>
	</form>
</body>
</html>