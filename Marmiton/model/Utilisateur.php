<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
class utilisateurs {
	private $pseudo;
	private $email;
	private $password;
	private $Admin;
	private $Photo;

	//getter
	public function getpseudo() {return $this->pseudo;}
	public function getemail() {return $this->email;}
	public function getpassword() {return $this->password;}
	public function getAdmin() {return $this->Admin;}
	public function getPhoto() {return $this->Photo;}
	

	public function __construct($ps=NULL,$m= NULL,$p= NULL,$a = NULL, $A = NULL)  {
		if (!is_null($ps) && !is_null($m) && !is_null($p) && !is_null($a)&& !is_null($A)) {
        $this->pseudo = $ps;
		$this->email = $m;
		$this->password = $p;
		$this->Admin = $a;
		$this->Photo = $A;
        }
	} 
		
	public static function AfficherUtilisateur($pseudo) {
		$requetePreparee = "SELECT * FROM utilisateurs WHERE pseudo = :tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_pseudo" => $pseudo);
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
	public  function Utilsateurprésentation(){
	echo "<div class=imgUtil>";
		$a= $this->Admin;
	if(isset($_SESSION['Admin'])){
		if($_SESSION['Admin']==2 or $_SESSION["User"]=$this->pseudo){
			echo "<a  href='routeurUtilisateur.php?action=update&pseudo=$this->pseudo' ><img class=ppprofil src=$this->Photo alt=avatar>";
		} else{
			echo "<img class=ppprofil src=$this->Photo alt=avatar>";
		}
	} else { echo "<img class=ppprofil src=$this->Photo alt=avatar>";}
		echo "</div>";
		echo "<h2>  $this->pseudo";
		switch ($a){
			case 2: echo " [ADMIN] </h2>"; break;
			case 1: echo "[MODO] </h2>"; break ;
			case 0: echo "[Utilisateurs] </h2>"; break;
		}
		
	}
	
	public  function UtilisateurModo(){
		echo "<a  href='routeurUtilisateur.php?action=afficher&id=$this->pseudo' > <h2 class=recette>  $this->pseudo<h2> </a>";
		switch ( $this->Admin){
			case 2: echo "<h2  class=recette> [ADMIN] </h2>"; break;
			case 1: echo "<h2  class=recette>[MODO] </h2>"; break ;
			case 0: echo "<h2  class=recette>[Utilisateurs] </h2>"; break;
		}
		echo "<div class=recette>";
		echo "<img class=ppprofil src=$this->Photo alt=avatar>";
			echo "<div class=recette>";

	}
	/*public static function afficherTaches() {
		$requete = "SELECT * FROM Taches;";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Taches');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}

	public static function AfficheruneTache($numTache) {
		$requetePreparee = "SELECT * FROM Taches WHERE numTache = :tag_numTache;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_numTache" => $numTache);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Taches');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	*/

    public static function update($pseudo,$photo) {
		$requetePreparee = "UPDATE utilisateurs SET  Photo = :tag_photo WHERE pseudo = :tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_photo" => $photo,
			"tag_pseudo" => $pseudo,
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}

	public static function setModo($pseudo) {
		$requetePreparee = "UPDATE utilisateurs SET  Admin = 1 WHERE pseudo = :tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_pseudo" => $pseudo,
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}

	public static function unModo($pseudo) {
		$requetePreparee = "UPDATE utilisateurs SET  Admin = 0 WHERE pseudo = :tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_pseudo" => $pseudo,
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}

	/*public function supprimer($numTache) {
		$requetePreparee = "DELETE FROM Taches WHERE numTache = :tag_numTache;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("tag_numTache" => $numTache);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}*/
	
	public function rechercheRe ($nom){
		$requetePreparee = "SELECT * FROM utilisateurs  WHERE  pseudo LIKE :tag_nom ";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			":tag_nom" => "%$nom%",
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

}

?>