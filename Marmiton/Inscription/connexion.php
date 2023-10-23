<?php 
    session_start(); // Démarrage de la session
    require_once("../conf/Connexion.php");; // On inclut la connexion à la base de données
    Connexion::Connect();
    if(!empty($_POST['email']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'il sont pas vident
    {
        // Patch XSS
        $email = htmlspecialchars($_POST['email']); 
        $password = htmlspecialchars($_POST['password']);
        
        $email = strtolower($email); // email transformé en minuscule
        
        // On regarde si l'utilisateur est inscrit dans la table utilisateurs
        $check =Connexion::pdo()->prepare('SELECT pseudo, email, password , Admin, Photo FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();
        

        // Si > à 0 alors l'utilisateur existe
        if($row > 0)
        {
            // Si le mail est bon niveau format
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // Si le mot de passe est le bon
                if($password === $data['password'])
                {
                    // On créer la session 
                    $_SESSION['user'] = $data['pseudo'];
					$_SESSION['mdp'] = $data['password'];
                    $_SESSION['Admin']=$data['Admin'];
					$_SESSION['Photo']=$data['Photo'];

                    header("Location: ../routeur.php");
                    die();
                }else{ header("Location:index.php?login_err=password&p=$password&pv=$pv"); die(); }
            }else{ header('Location: index.php?login_err=email'); die(); }
        }else{ header('Location: index.php?login_err=already'); die(); }
    }else{ header('Location: index.php'); die();} // si le formulaire est envoyé sans aucune données
