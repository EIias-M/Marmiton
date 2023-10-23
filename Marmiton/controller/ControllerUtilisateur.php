<?php  
    require_once("./model/Utilisateur.php");
class controllerUtilisateur{

	public static function default(){
		require_once("./routeur.php");
	}
	public static function afficher(){
		$id = $_GET['id'];
		$utilisateur= utilisateurs::AfficherUtilisateur($id);
		require_once("./viewUtilisateur/Affichage.php");
	}

	public static function update(){
		$pseudo = $_GET['pseudo'];
		$Us=utilisateurs::AfficherUtilisateur($pseudo);
		require_once("./viewUtilisateur/update.php");
	}

	public static function setModo(){
		$pseudo = $_GET['pseudo'];
		utilisateurs::setModo($pseudo);
		$utilisateur= utilisateurs::AfficherUtilisateur($pseudo);
		require_once("./viewUtilisateur/Affichage.php");
	}

	public static function unModo(){
		$pseudo = $_GET['pseudo'];
		utilisateurs::unModo($pseudo);
		$utilisateur= utilisateurs::AfficherUtilisateur($pseudo);
		require_once("./viewUtilisateur/Affichage.php");
	}

	public static function updated(){
		$pseudo = $_GET['pseudo'];
		$photo= $_GET["photo"];
		utilisateurs::update($pseudo,$photo);
		$utilisateur= utilisateurs::AfficherUtilisateur($pseudo);
		require_once("./viewUtilisateur/Affichage.php");

	}
	public static function admin(){
		require_once("./viewUtilisateur/Modérateur.php");
	}
	
	public static function Recherche(){
		$nom = $_GET['rech'];
		$utilisateur = utilisateurs::rechercheRe ($nom);
		require_once("./viewUtilisateur/Modérateur.php");
	}

}
?>