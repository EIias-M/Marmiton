<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
class Ustensile {
	private $NomUstensile;
	private $QuantiteUstensile;
	private $PhotoUstensile;
	private $ID;

	//getter
	public function getnomUstensile() {return $this->NomUstensile;}
	public function getQuantiteUstensile() {return $this->QuantiteUstensile;}
	public function getPhotoUstensile() {return $this->PhotoUstensile;}
	public function getID() {return $this->ID;}

	public function __construct($n=NULL,$l= NULL,$f = NULL,$i= NULL)  {
		if (!is_null($n) && !is_null($l) && !is_null($f)) {
        $this->NomUstensile = $n;
		$this->QuantiteUstensile = $l;
		$this->PhotoUstensile = $f;
		$this->ID = $i;

        }
	} 

	public function afficher() {
		echo "<h3> $this->QuantiteUstensile $this->NomUstensile</h3>";
		echo '<img style="width: 500px;heigth: 500px;border-radius;:500px"src="'.$this->PhotoUstensile.'"/><br/>';
	}

	public static function afficherUstensile() {
		$requete = "SELECT * FROM Ustensile";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Ustensile');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}

	public static function AfficherunUstensile($NomUstensile) {
		$requetePreparee = "SELECT * FROM Ustensile WHERE nomUstensile= :tag_nomUstensile";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array( 
			"tag_nomUstensile" => $NomUstensile
	);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Ustensile');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
	public static function UstensileRecette($idRecette) {
		$requetePreparee = "SELECT * FROM QuantitéUstensile WHERE IDRecette= :tag_idRecette";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_idRecette" => $idRecette,
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'QuantitéUstensile');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
	public static function AfficherunUstensileQ($NomUstensile,$ID) {
		$requetePreparee = "SELECT * FROM Ustensile inner join QuantitéUstensile on Ustensile.NomUstensile=QuantitéUstensile.NomUstensile WHERE nomUstensile= :tag_nomUstensile AND IDRecette= :tag_IDRecette;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array( 
			"tag_nomUstensile" => $NomUstensile,
			"tag_IDRecette" => $ID
	);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Ustensile');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
    public static function addUstensile($NomUstensile,$PhotoUstensile) {
		$requetePreparee = "INSERT INTO Ustensile VALUES(:tag_NomUstensile,:tag_PhotoUstensile);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomUstensile" => $NomUstensile,
			"tag_PhotoUstensile" => $PhotoUstensile
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}
	
	/* Problème ! 
	** L'inséertion par une requête préparer crée un problème, on pense que l'utilisation d'une réquête préparer entraine un beug
	** le site nous dit que l'inséertion ne peut se faire alor qu'on peut. Nous somme donc passer a une requete qui n'es pas  une
	** requete préparer.
	*/
	public static function  addQuantité($NomUstensile,$QuantiteUstensile,$ID){
		$requete = "INSERT INTO QuantitéUstensile VALUES ($NomUstensile,$ID,$QuantiteUstensile)";
		$resultat = Connexion::pdo()->query($requete);

	}
	/*
	public static function addQuantité($NomUstensile,$QuantiteUstensile,$ID){
	$requetePreparee = "INSERT INTO QuantitéUstensile VALUES(:tag_NomUstensile,:tag_IDRecette,:tag_QuantitéUstensile);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomUstensile" => $NomUstensile,
			"tag_IDRecette" => $ID,
			"tag_QuantiteUstensile" => $QuantiteUstensile
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}
	*/
    public static function updateUstensile($NomUstensile,$QuantiteUstensile,$PhotoUstensile) {

		$requetePreparee = "UPDATE Ustensile SET PhotoUstensile = :tag_PhotoUstensile WHERE NomUstensile = :tag_NomUstensile;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomUstensile" => $NomUstensile,
			"tag_PhotoUstensile" => $PhotoUstensile
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}

	public function supprimer($NomUstensile) {
		$requetePreparee = "DELETE FROM Ustensile WHERE  NomUstensile = :tag_NomUstensile;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_NomUstensile" => $NomUstensile);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;

	$requetePreparee = "DELETE FROM QuantitéUstensile WHERE  NomUstensile = :tag_NomUstensile";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomUstensile" => $NomUstensile,
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}

	public function supprimerR($ID) {
		$requetePreparee = "DELETE FROM QuantitéUstensile WHERE IDRecette= :tag_ID;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_IDRecette" => $ID
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}

}

?>