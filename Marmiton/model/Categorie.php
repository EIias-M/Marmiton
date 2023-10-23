<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
class Categorie {
	private $NomCategorie;
	private $ID;
	
	//getter
	public function  getNomCategorie() {return $this->NomCategorie;}
	public function getID() {return $this->ID;}

	public function __construct($n=NULL)  {
		if ((!is_null($n)) && !(is_null($i))) {
        $this->NomCategorie = $n;
		$this -> ID=$i;
        }
	} 

	public function afficher() {
		echo "<p>Categorie $this->NomCategorie</p>";
	}

	public static function afficherCategorie() {
		$requete = "SELECT * FROM Categorie;";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Categorie');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}
		public static function UstensileCategorie($idRecette) {
		$requetePreparee = "SELECT * FROM Appartient WHERE IDRecette= :tag_idRecette";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_idRecette" => $idRecette,
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Appartient');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
    public static function addCategorie($NomCategorie) {
		$requetePreparee = "INSERT INTO Categorie VALUES(:tag_nomCategorie);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_nomCategorie" => $NomCategorie
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
	public static function  addCategorieR($NomCategorie,$ID){
		$requete = "INSERT INTO Appartient VALUES ($ID,$NomCategorie)";
		$resultat = Connexion::pdo()->query($requete);

	}
	/*
	
	public static function addCategorieR($NomCategorie,$ID) {
		$requetePreparee = "INSERT INTO Appartient VALUES(:tag_nomCategorie,:tag_ID);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_nomCategorie" => $NomCategorie,
			"tag_ID"=> $ID
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}
	*/
	
		public function supprimer($NomCategorie) {
		$requetePreparee = "DELETE FROM Categorie WHERE NomCategorie = :tag_nomCategorie;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_nomCategorie" => $NomCategorie);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
		}

		public function Deleteapartien($tag_NomCategorie, $ID){
		$requetePreparee = "DELETE FROM Appartient WHERE  NomCategorie = :tag_NomCategorie AND IDRecette= :tag_ID;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomCategorie" => $tag_NomCategorie,
			"tag_IDRecette" => $ID
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
		$requetePreparee = "DELETE FROM Appartient WHERE IDRecette= :tag_ID;";
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