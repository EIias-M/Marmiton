<?php 
    session_start();
    require_once("../conf/Connexion.php"); // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php?p=3');
        die();
    }

    // On récupere les données de l'utilisateur
   
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Espace membre</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>


                <div class="text-center">
                        <h1 class="p-5">Bonjour <?php echo $_SESSION['user']; ?> !</h1>
                        <hr />
                        <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
                    
                </div>
            </div>
        </div>    

       

        

  </body>
</html>
