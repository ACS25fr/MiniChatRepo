<?php
/*
DESCRIPTION:
    DONNEES D'ENTREE
        - N/A
    TRAITEMENT:
        Affiche le message "Au revoir" & prénom du visiteur
        met fin à la session
    RESULTATS:
        - fin de session
*/
// Démarrage session
session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="index.css" rel="stylesheet" />
        <title>Minichat avec thèmes.</title>
    </head>
    <body>
        <h1>Au revoir 
        <?php
        
        // si la session à été utilisée
        if (!empty($_SESSION)){
            // personaliser le message de fin une dernière fois 
            echo $_SESSION['mnc_prenom'];
            // Libération de la mémoire 
            $_SESSION = array(); 
            // Arrêter la sesssion
            session_destroy();
//session_start();
// Intialiser les variables de session
//include 'minichat_init_var_session.php';
        }     
        ?>
        !
        </h1>
         
    </body>
</html>   

