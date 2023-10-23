<?php 
    require_once("./conf/Connexion.php");
    Connexion::Connect();
	
class Commentaires {
	private $note;
	private $texte;
	private $pseudo;
	private $IDRecette;

	//getter
	public function getNote() {return $this->note;}
	public function getTexte() {return $this->texte;}
	public function getLogin() {return $this->pseudo;}
	public function getID() {return $this->IDRecette;}


	public function __construct($n=NULL,$t= NULL,$l = NULL,$i = NULL)  {
		if (!is_null($n) && !is_null($l) && !is_null($t) && !is_null($i)) {
        $this->note = $n;
		$this->pseudo = $l;
		$this->texte = $t;
		$this->IDRecette = $i;
        }
	} 
	public function CommentaireUtilisateur(){
	require_once("./model/Utilisateur.php");
	$utilisateur = utilisateurs::AfficherUtilisateur("$this->pseudo");
	$photo = $utilisateur[0]->getPhoto();

	echo "<table class=com>";

	echo"<td>  <a href='routeurUtilisateur.php?action=afficher&id=$this->pseudo' ><img class=ppcom src=$photo alt=avatar></a></td>";
	$zaeza = (string)$this-> note;
    echo" <td> <p> $this->pseudo : $zaeza </p> <p>$this->texte</p> </td>";
	echo"</table><br>";
	}


	public static function afficherComm() {
		$requete = "SELECT * FROM Commentaires;";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'Commentaires');
		$tableau = $resultat->fetchAll();
		return $tableau;
	}
	public static function AfficherlesCommentaires($IDRecette) {
		$requetePreparee = "SELECT * FROM Commentaires WHERE ID= :tag_ID";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $IDRecette,
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Commentaires');
			$v= $req_prep->fetchAll();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}

	public static function AfficherunComm($pseudo,$IDRecette) {

		$requetePreparee = "SELECT * FROM Commentaires WHERE pseudo= :tag_pseudo AND ID= :tag_ID";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $IDRecette,
			"tag_pseudo" => $pseudo
		);
		try {
			$req_prep->execute($valeurs);
			$req_prep->setFetchMode(PDO::FETCH_CLASS,'Commentaires');
			$v = $req_prep->fetch();
			if (!$v) 
				return false;
			return $v;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
		return false;
	}
	
    public static function addComm($IDRecette,$pseudo,$note,$texte) {
		$requetePreparee = "INSERT INTO Commentaires VALUES(:tag_ID,:tag_pseudo,:tag_note,:tag_texte);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $IDRecette,
			"tag_pseudo" => $pseudo,
			"tag_texte" => $texte,
            "tag_note" => $note
		);
		try {
			$req_prep->execute($valeurs);
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
		}
	}

    public static function updateComm($IDRecette,$pseudo,$note,$texte) {
		$requetePreparee = "UPDATE Commentaires SET  note = :tag_note, texte = :tag_texte WHERE ID = :tag_ID AND pseudo= :tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $IDRecette,
			"tag_pseudo" => $pseudo,
			"tag_texte" => $texte,
            "tag_note" => $note
		);
		try {
			$req_prep->execute($valeurs);
			return true;
		} catch (PDOException $e) {
			echo "erreur : ".$e->getMessage()."<br>";
			return false;
		}
	}	

	

	public function supprimer($IDRecette,$pseudo) {
		$requetePreparee = "DELETE FROM Commentaires WHERE ID = :tag_ID AND pseudo=:tag_pseudo;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"tag_ID" => $IDRecette,
			"tag_pseudo" => $pseudo
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
		$requetePreparee = "DELETE FROM Commentaires WHERE IDRecette= :tag_ID;";
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
	


	public static function verif($texte) {
		$requete = "SELECT * FROM mot_interdit;";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchMode(PDO::FETCH_CLASS,'mot_interdit');
		$tableau = $resultat->fetchAll();
		
		foreach($tableau as $mot){
			if(preg_match("/{$mot}/i", $texte)) {
				return True;
				break;
			 }
		}
		return false;
		
	}

}

?>