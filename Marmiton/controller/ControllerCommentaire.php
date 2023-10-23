<?php  
require_once("./model/Commentaire.php");
class controllerCommentaire{

    public static function AfficherTous(){
        $lesComs = Commentaires::afficherComm();
        require("viewComm/Affichage.php");
    }

    public static function update(){
        $IDRecette= $_GET["ID"];
		$pseudo= $_GET["pseudo"];
		$comm = Commentaires::AfficherunComm($pseudo,$IDRecette);
		require("viewComm/update.php");
    }

    public static function updated() {
		$IDRecette = $_GET["ID"];
		$pseudo=$_GET["pseudo"];
		$texte = $_GET["texte"];
		$note= $_GET["note"];
		Commentaires::updateComm($IDRecette,$pseudo,$note,$texte);
		self::AfficherTous();
	}
    
    public static function delete() {
		$IDRecette= $_GET["IDRecette"];
		$pseudo= $_GET["pseudo"];
		Commentaires::supprimer($IDRecette,$pseudo);
		header("Location:routeurRecette.php?action=UneRecette&recette=$IDRecette");
		//		self::AfficherTous();
	}



	public static function created() {
		$IDRecette = $_GET["ID"];
		$pseudo=$_GET["pseudo"];
		$texte = $_GET["texte"];
		$note= $_GET["note"];
		if(Commentaires::verif($texte)){
			echo "Votre commentaire est injurieux";
		} else{
			Commentaires::addComm($IDRecette,$pseudo,$note,$texte);
		}
		header("Location:routeurRecette.php?action=UneRecette&recette=$IDRecette");
	}
}
?>