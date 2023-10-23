<?php  
    require_once("./model/Categorie.php");
class controllerCategorie{

    public static function AfficherTous(){
        $lesCatego = Categorie::afficherCategorie();
        require("viewCate/Affichage.php");
    }
    
    public static function delete() {
		$Nom = $_GET["nomCategorie"];
		Categorie::supprimer($Nom);
		self::AfficherTous();
	}

    public static function create() {
		require("viewCate/create.php");
	}


	public static function created() {
		$nomCate = $_GET["NomCategorie"];
		Categorie::AddCategorie($nomCate);
		self::AfficherTous();
	}
}
?>