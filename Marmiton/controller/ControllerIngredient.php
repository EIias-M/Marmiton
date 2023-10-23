<?php  
    require_once("./model/Ingredient.php");
class controllerIngredient{

    public static function AfficherTous(){
        $lesIngre = Ingredient::afficherIngre();
        require("viewIngre/Affichage.php");
    }

	public static function AfficherUnIngredient() {
		$nomIngre = $_GET["nomIngredient"];
		
		$Ingre=Ingredient::AfficherunIngre($nomIngre);
		require("viewIngre/detail.php");
	}

    public static function AfficherUnIngredientQ() {
		$nomIngre = $_GET["NomIngredient"];
		$ID=$_GET["ID"];
		$Ingre=Ingredient::AfficherUnIngredient($nomIngre,$ID);
		require("viewIngre/detail.php");
	}

	
	public static function update(){
        $nomIngre = $_GET["nomIngredient"];
		$Ingre = Ingredient::AfficherUnIngre($nomIngre);
		require("viewIngre/update.php");
    }

    public static function updated() {
		$nomIngre = $_GET["NomIngrédient"];
		$photo = $_GET["photo"];
		Ingredient::updateIngredient($nomIngre,$photo);
		self::AfficherTous();
	}

    public static function delete() {
		$nomIngredient = $_GET["nomIngredient"];
		Ingredient::supprimer($nomIngredient);
		self::AfficherTous();
	}

	public static function create() {
		require("viewIngre/create.php");
	}

	public static function created() {
		$nomIngre = $_GET["nomIngredient"];
		$photoIngredient = $_GET["photoIngredient"];
		Ingredient::addIngredient($nomIngre,$photoIngredient);
		self::AfficherTous();
	}
}
?>