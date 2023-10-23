<?php  
    require_once("./model/Ustensile.php");
class controllerUstensile{

    public static function AfficherTous(){
        $lesUst = Ustensile::afficherUstensile();
        require("viewUstensile/Affichage.php");
    }

    public static function AfficherUnUstensile() {
		$nomUst = $_GET["NomUstensile"];
		$Ust=Ustensile::AfficherUnUstensile($nomUst);
		require("viewUstensile/detail.php");
	}

	public static function AfficherUnUstensileQ() {
		$nomUst = $_GET["NomUstensile"];
		$ID=$_GET["ID"];
		$Ust=Ustensile::AfficherUnUstensileQ($nomUst,$ID);
		require("viewUstensile/detail.php");
	}

    public static function update(){
        $nomUst = $_GET["nomUst"];
		$ID=$_GET["ID"];
		$Ust = Ustensile::AfficherUnUstensile($nomUst,$ID);
		require("viewUstensile/update.php");
    }

    public static function updated() {
		$nomUst = $_GET["NomUstensile"];
		$quantiteUst=$_GET["QuantiteUstensile"];
		$photoUstensile = $_GET["PhotoUstensile"];
		$ID=$_GET["ID"];
		Ustensile::updateUstensile($nomUst,$quantiteUst,$photoUstensile,$ID);
		self::AfficherTous();
	}
    
    public static function delete() {
		$nomUstensile = $_GET["NomUstensile"];
		Ustensile::supprimer($nomUstensile);
		self::AfficherTous();
	}

    public static function create() {
		require("viewUstensile/create.php");
	}

	public static function createQ() {
		//
	}
	
	public static function created() {
		$nomUst = $_GET["NomUstensile"];
		$photoUstensile = $_GET["photoUstensile"];
		Ustensile::addUstensile($nomUst,$photoUstensile);
		self::AfficherTous();
	}


	public static function createdQ() {
		$nomUst = $_GET["NomUstensile"];
		$quantiteUst=$_GET["QuantiteUstensile"];
		$ID=$_GET["ID"];
		Ustensile::addQuantité($nomUst,$quantiteUst,$ID);
		self::AfficherTous();
	}
}
?>