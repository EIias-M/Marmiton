<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
class Ingredient {
	private $NomIngredient;
	private $PhotoIngredient;
	private $Quantité;
	private $UnitédeMesure;
	private $ID;
	//getter
	public function getnomIngredient() {return $this->NomIngredient;}
	public function getphotoIngredient() {return $this->PhotoIngredient;}
	public function getQuantité() {return $this->Quantité;}
	public function getUnitédeMesure() {return $this->UnitédeMesure;}
	public function getID() {return $this->ID;}

	public function __construct($n=NULL,$p=NULL,$q=NULL,$u=NULL,$i=NULL)  {
		if (!is_null($n)  && !is_null($p) && !is_null($q)  && !is_null($u) && !is_null($i)) {
        $this->NomIngredient = $n;
		$this -> PhotoIngredient= $p;
		$this -> Quantité = $q;
		$this ->  UnitédeMesure = $u;
		$this -> ID = $i;
        }
	} 

	// afficher le nom,la quantité et le chemin vers l'image
	public function afficher() {
		echo "<h3> $this->NomIngredient </h3>";
		echo "<img src=$this->PhotoIngredient/><br/>";

	}

	public static function afficherIngre() {
		$requete = "SELECT * FROM Ingredient";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Ingredient');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}


	public static function AfficherunIngre($nomIngredient) {
		$requetePreparee = "SELECT * FROM Ingredient WHERE nomIngredient= :tag_nomIngredient";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array( 
			"tag_nomIngredient" => $nomIngredient
	);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Ingredient');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}

	public static function AfficherunIngreQ($nomIngredient,$ID) {
		$requetePreparee = "SELECT * FROM Ingredient inner join QuantitéIngrédient on Ingredient.NomIngredient=QuantitéIngrédient.NomIngredient WHERE nomIngredient= :tag_nomIngredient AND IDRecette= :tag_IDRecette;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array( 
			"tag_nomIngredient" => $NomIngredient,
			"tag_IDRecette" => $ID
	);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Ingredient');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	public static function IngrédientRecette($idRecette) {
		$requetePreparee = "SELECT * FROM QuantitéIngrédient WHERE IDRecette= :tag_idRecette";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_idRecette" => $idRecette,
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'QuantitéIngrédient');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
    public static function addIngredient($NomIngredient,$photoIngredient) {
		$requetePreparee = "INSERT INTO Ingredient VALUES(:tag_NomIngredient,:tag_PhotoIngredient);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomIngredient" => $NomIngredient,
			"tag_PhotoIngredient" => $photoIngredient
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
	public static function  addQuantité($NomIngredient,$Quantité,$ID,$UnitédeMesure){
		$requete = "INSERT INTO QuantitéIngrédient VALUES ($ID,$NomIngredient,$Quantité,$UnitédeMesure)";
		$resultat = Connexion::pdo()->query($requete);

	}
	/*public static function addQuantité($NomIngredient,$Quantité,$ID,$UnitédeMesure){
		echo"<p> $ID,$NomIngredient,$Quantité,$UnitédeMesure</p>";
		$requetePreparee = "INSERT INTO QuantitéIngrédient VALUES(:tag_IDRecette,:tag_NomIngredient, :tag_Quantite, :tag_Unite);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_IDRecette" => $ID,
			"tag_NomIngredient" => $NomIngredient,
			"tag_Quantite" => $Quantité,
			"tag_Unite"=> $UnitédeMesure
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}*/

    public static function updateIngredient($NomIngredient,$PhotoIngredient) {

		$requetePreparee = "UPDATE Ingredient SET PhotoIngredient = :tag_PhotoIngredient WHERE NomIngredient = :tag_NomIngredient;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomIngredient" => $NomIngredient,
			"tag_PhotoIngredient" => $PhotoIngredient
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}
	

	public function supprimer($NomIngredient) {
		$requetePreparee = "DELETE FROM Ingredient WHERE  NomIngredient = :tag_NomIngredient;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_NomIngredient" => $NomIngredient);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;

	$requetePreparee = "DELETE FROM QuantitéIngrédient WHERE  NomIngredient = :tag_NomIngredient";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_NomIngredient" => $NomIngredient
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
		$requetePreparee = "DELETE FROM QuantitéIngrédient WHERE IDRecette= :tag_ID;";
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