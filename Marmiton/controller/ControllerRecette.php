<?php  
    require_once("./model/Recette.php");

	
	require_once("./controller/ControllerUstensile.php");
	require_once("./controller/ControllerIngredient.php");
	require_once("./controller/ControllerCategorie.php");
	require_once("./controller/ControllerCommentaire.php");


class controllerRecette{
	
    public static function AfficherTous(){
        $lesRecettes = Recettes::afficherRecettes();


        require("viewRecette/Affichage.php");
    }
	
	public static function Recherche(){
		$nom = $_GET['rech'];
		$user = Recettes::recherche ($nom);
		$createur = null;
		if(!empty($user)){
			$lesRecettes = Recettes::rechercheR($nom);
			
			if($lesRecettes == null) {

				$lesRecettes= Recettes::rechercheRe($nom);
			}else{$createur = $user ;}
		} else{
			$lesRecettes= Recettes::rechercheRe($nom);
		}
		require("viewRecette/Affichage.php");
		
	}
    
    public static function delete() {
		$IdRecette= $_GET["ID"];
		Recettes::supprimerRecettes($IdRecette);
		self::AfficherTous();
	}

	public static function update(){
		$id=$_GET["ID"];
		$Lesustensiles=Ustensile::afficherUstensile();
		$Lesingrédient=Ingredient::afficherIngre();
		$LesCatégories=Categorie::afficherCategorie();
		$laRecette=Recette::afficheruneRecettes($id);

		require("viewRecette/update.php");
	}

	public static function updated() {
		$id = $_GET["ID"];
		$Nom  = $_GET["Nom"]; 
		$NbPersonnes  = $_GET["NbPersonnes"]; 
		$TempsDePreparation  = $_GET["TempsDePreparation"]; 
		$Description  = $_GET["Description"]; 
		$Photo  = $_GET["Photo"]; 
		$Pseudo  = $_GET["Pseudo"]; 
		$NiveauDeDifficulter  = $_GET["NiveauDeDifficulter"];
		
		
		
		
		Recettes::update($NbPersonnes, $TempsDePreparation, $Description, $Photo , $Pseudo, $NiveauDeDifficulter);
		//Ingredient::Soluce();
		
		Categorie::supprimerQ($id);
		Ingrédient::supprimerQ($id);
		Ustensile::supprimerQ($id);

		$i =1;
		$t="";
		$test=true;
		while (isset( $_GET["ingredient$i"])) {	
			
			$ingredient = $_GET["ingredient$i"];
			$ingredient ="'$ingredient'";
			$qtq = $_GET["qtq$i"];
			$Mesure = $_GET["Mesure$i"];
			$Mesure="'$Mesure'";

			foreach($t as $U){
				if($U==$ingredient){
					 $test =false;
				}
			}
			if($test==true){
				Ingredient::addQuantité($ingredient,$qtq,$id,$Mesure);
				$t=array($ingredient);
			};
			$i = $i +1;
		}

		$u=1;
		$t="";
		$test=true;
		while (isset( $_GET["Ustensile$u"])) {
			
			$Ustensile = $_GET["Ustensile$u"];
			$Ustensile= "'$Ustensile'";
			$Quantite = $_GET["Quantite$u"];
			foreach($t as $U){
				if($U==$Ustensile){
					 $test =false;
				}
			}
			if($test==true){
				Ustensile::addQuantité($Ustensile,$Quantite,$id);
			}
			$t=array($Ustensile);
			$u=$u+1;
		}

		$c=1;
		$t="";
		$test=true;
		while (isset( $_GET["Categories$c"])) {
			$Categories = $_GET["Categories$c"];
			$Categories = "'$Categories'";
			foreach($t as $U){
				if($U==$Categories){
					 $test =false;
				}
			}
			if($test==true){
				Categorie::addCategorieR($Categories,$id);
			}
			$t=array($Categories);
			$c=$c+1;
		}
		
		
		header('Location:routeur.php');
		//self::AfficherTous();
	}


    public static function create() {
		
		$Lesustensiles=Ustensile::afficherUstensile();
		$Lesingrédient=Ingredient::afficherIngre();
		$LesCatégories=Categorie::afficherCategorie();
		
		require("viewRecette/create.php");
	}

	public static function created() {
		$id = sizeof(Recettes::afficherRecettes());
		$Nom  = $_GET["Nom"]; 
		$NbPersonnes  = $_GET["NbPersonnes"]; 
		$TempsDePreparation  = $_GET["TempsDePreparation"]; 
		$Description  = $_GET["Description"]; 
		$Photo  = $_GET["Photo"]; 
		$Pseudo  = $_GET["Pseudo"]; 
		$NiveauDeDifficulter  = $_GET["NiveauDeDifficulter"];
		
		
		
		Recettes::addRecettes( $Nom, $NbPersonnes, $TempsDePreparation, $Description, $Photo , $Pseudo, $NiveauDeDifficulter);
		//Ingredient::Soluce();
		
		$i =1;
		while (isset( $_GET["ingredient$i"])) {	
			$ingredient = $_GET["ingredient$i"];
			$ingredient ="'$ingredient'";
			$qtq = $_GET["qtq$i"];
			$Mesure = $_GET["Mesure$i"];
			$Mesure="'$Mesure'";
			Ingredient::addQuantité($ingredient,$qtq,$id,$Mesure);
			$i = $i +1;
		}
		$u=1;
		while (isset( $_GET["Ustensile$u"])) {
			
			$Ustensile = $_GET["Ustensile$u"];
			$Ustensile= "'$Ustensile'";
			$Quantite = $_GET["Quantite$u"];
			Ustensile::addQuantité($Ustensile,$Quantite,$id);
			$u=$u+1;
		}
		$c=1;
		while (isset( $_GET["Categories$c"])) {
			$Categories = $_GET["Categories$c"];
			$Categories = "'$Categories'";
			Categorie::addCategorieR($Categories,$id);
			$c=$c+1;
		}
		
		
		header('Location:routeur.php');
		//self::AfficherTous();
	}

	public static function supprimer() {
		$id = $_GET["ID"];
		
		Categorie::supprimerQ($id);
		Ingrédient::supprimerQ($id);
		Ustensile::supprimerQ($id);
		Commentaires::supprimer($id);
		Recette::supprimerRecettes($id);
		
		
		header('Location:routeur.php');
		//self::AfficherTous();
	}


	public static function home(){
		$lesRecettes = Recettes::afficherRecettes();
		
		require("viewHome/HomePage.php");
	}
	
	public static function UneRecette(){
		//require_once("./model/Commentaire.php");
		$laRecette = Recettes::AfficheruneRecettes($_GET["recette"]);
		$Ingredients = Ingredient::IngrédientRecette($_GET["recette"]);
		$Ustenisles = Ustensile::UstensileRecette($_GET["recette"]);
		$Categories =  Categorie::UstensileCategorie($_GET["recette"]);
		$CommentairesUtilisateur = Commentaires::AfficherlesCommentaires($_GET["recette"]);
		
	
	require("viewRecette/Affichage1recette.php");
	}
}
  
?>