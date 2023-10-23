<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
	
class Recettes {
	private $ID;
	private $Nom;
	private $NbPersonnes;
	private $TempsDePreparation;
	private $Description;
	private $Photo;
	private $Pseudo;
	private $NiveauDeDifficulté;
	
	//getter

	public function  getID() {return $this->ID; }
	public function  getNom() {return $this->Nom;}
	public function  getNbPersonnes() {return $this->NbPersonnes;}
	public function  getTempsDePreparation() {return $this->TempsDePreparation;}
	public function  getDescription() {return $this->Description;}
	public function  getPhoto() {return $this->Photo;}
	public function  getPseudo() {return $this->Pseudo;}
	public function  getNiveauDeDifficulté() {return $this->NiveauDeDifficulté;}


	public function __construct($id = null, $nom= null, $nbPersonnes= null, $tempsdepreparation= null, $description= null, $photo = null, $Pseudo= null, $NiveauDeDifficulter= null){
		
		if  (!is_null($id) && !is_null($nom) && !is_null($nbPersonnes) && !is_null($tempsdepreparation) && !is_null($description) && !is_null($photo) && !is_null($Pseudo) && !is_null($NiveauDeDifficulter) ){
        $this->Photo = $photo;
		
		$this->ID = $id;
		$this->Nom =  $nom;
		$this->NbPersonnes = $nbPersonnes;
		$this->TempsDePreparation =$tempsdepreparation;
		$this->Description = $description;
		$this->Pseudo = $Pseudo;
		$this->NiveauDeDifficulté =  $NiveauDeDifficulter;
		}
		
		
	} 
	
	public function affichageMenuRecette(){
			echo '<table>';
			echo '<tr>';
			if ( $this->Photo != null ) {
			echo "  <td> <a href= routeurRecette.php?action=UneRecette&recette=$this->ID ><img src=$this->Photo> </a></td> " ;
			}
			echo "<td><a  href= routeurRecette.php?action=UneRecette&recette=$this->ID <p> $this->Nom </p>  <p> Pour $this->NbPersonnes </p> 
			<p> Préparation $this->TempsDePreparation min </p>   <p> De difficulter $this->NiveauDeDifficulté </p> </a> </td>";
			echo '</tr>';
			echo '</table>';
	}
	public function afficher($Ingredients,$Ustenisles,$Categories ) {
		echo " <h3 class=recette> $this->Nom </h3>";
		
		echo "<div class=recette > <img src= $this->Photo> </img> </div>";
		
		if($Ingredients!=null){
			echo "<div class=ingredient> <p> Ingrédient : </p>";
			foreach ($Ingredients as $ingrédient){
				echo "<p> $ingrédient[NomIngredient] : $ingrédient[Quantité] $ingrédient[Unitédemesure]</p>";
			} 
			echo "</div>";
		}
		
		if($Ustenisles!=null){
			echo "<div class=ustensile> <p> Ustensiles : </p>";
			foreach ($Ustenisles as $ustensile){
				echo "<p> $ustensile[NomUstensile] : $ustensile[QuantitéUstensile] </p>";
			} 
			echo "</div>";
		}
		if(	$Categories !=null){


			foreach ($Categories  as $cat){
				echo "<p class=recette> $cat[NomCategorie]  ";
			} 
			 echo "</p>";

		}
		
	
		echo "<p class=recette> Fait par : $this->pseudo , </p>";
		echo "<p class=recette>Difficulter :  $this->Niveaudedifficulté.</p>";
		echo "<p class=recette>Pour : $this->NbPersonnes.</p>";
		echo "<p class=recette>Temps : $this->Tempsdepreparation min. </p>";
		echo "<p class=recette>Recette :</p><p> $this->Description</p>";
	
	}
	public static function afficherRecettes() {

		$requete = "SELECT * FROM Recettes;";	
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Recettes');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}
	public static function AfficheruneRecettes($id) {
		$requetePreparee = "SELECT * FROM Recettes WHERE ID = :tag_ID";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $id,
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Recettes');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
    public static function addRecettes( $nom, $nbPersonnes, $tempsdepreparation, $description, $photo = null, $Pseudo, $niveaudedifficulter) {
		$id = sizeof(Recettes::afficherRecettes());
		$requetePreparee = "INSERT INTO Recettes VALUES(:tag_id, :tag_nom, :tag_nbPersonnes, :tag_tempsdepreparation, :tag_description, :tag_photo, :tag_Pseudo, :tag_niveaudedifficulter);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_id" => $id ,
			"tag_nom" => $nom, 
			"tag_nbPersonnes" => $nbPersonnes,
			"tag_tempsdepreparation" => $tempsdepreparation,
			"tag_description" =>  $description, 
			"tag_photo" => $photo,
			"tag_Pseudo" => $Pseudo, 
			"tag_niveaudedifficulter" => $niveaudedifficulter
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}
	
	public static function update($nbPersonnes, $tempsdepreparation, $description, $photo = null, $Pseudo, $niveaudedifficulter) {
		$id = sizeof(Recettes::afficherRecettes());
		$requetePreparee = "UPDATE Recettes SET NbPersonnes=:tag_nbPersonnes,Tempsdepreparation = :tag_tempsdepreparation, Description = :tag_description,Photo = :tag_photo,pseudo=:tag_Pseudo,Niveaudedifficulté=:tag_niveaudedifficulter where ID=:tag_id";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_id" => $id , 
			"tag_nbPersonnes" => $nbPersonnes,
			"tag_tempsdepreparation" => $tempsdepreparation,
			"tag_description" =>  $description, 
			"tag_photo" => $photo,
			"tag_Pseudo" => $Pseudo, 
			"tag_niveaudedifficulter" => $niveaudedifficulter
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}

	public function supprimerRecettes($id) {
		
		
		$requetePreparee0 = "DELETE FROM `Recettes` WHERE ID = :tag_IDR;";
		$req_prep0 = Connexion::pdo()->prepare($requetePreparee0);
		$valeurs0 = array(
			"tag_IDR" => $id,
		);
		try {
			$req_prep0->execute($valeurs0);
			
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}

		$idf = sizeof(Recettes::afficherRecettes());
		if($id != $idf){
			$requetePreparee = "UPDATE Recettes SET ID = :tag_IDR  WHERE ID = :tag_IDF;";
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			$valeurs = array(
				"tag_IDR" => $id,
				"tag_IDF" => $idf,
			);
			try {
				$req_prep->execute($valeurs);
				return true;
			} catch (PDOException $e) {
				echo "erreur : ".$e->getMessage()."<br>";
			}
			return false;
			}
	}
	
	public function rechercheRe ($nom){
		$requetePreparee = "SELECT * FROM Recettes  WHERE  nom LIKE :tag_nom ";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			":tag_nom" => "%$nom%",
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Recettes');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
		
	}


	
	public function recherche ($nom){
		$requetePreparee = "SELECT * FROM utilisateurs  WHERE  pseudo LIKE :tag_pseudo ";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			":tag_pseudo" => "%$nom%",
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'utilisateurs');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
		
	}

	
	public function rechercheR ($nom){
		$requetePreparee = "SELECT * FROM Recettes  WHERE  pseudo LIKE :tag_pseudo ";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			":tag_pseudo" => "%$nom%",
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Recettes');
			$v = $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
		
	}
}

?>