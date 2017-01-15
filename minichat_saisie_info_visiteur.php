<?php
/*
DESCRIPTION:
    DONNEES D'ENTREE
        - BD minichat
        - Variable de Session
            - nom, prénom, et adresse mail du visiteur 
    TRAITEMENT:
        Formulaire:
            - affichage du pseudo environné
            - input : confimation du mot de passe
            - input: Prénom de visiteur
            - input: Nom de visiteur
            - input: Adresse mail de visiteur
            - bouton: validation de la saisie
    RESULTATS:
        - Insertion d'un nouveau visiteur dans la table visiteurs de la BD minichat
        - lancement de la page selection de thème
*/
// Démarrage session
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="index.css" rel="stylesheet" type="text/css" media="all"/>
        <title>Minichat avec thèmes.</title>
    </head>
    <body>
       <h1>Merci de nous laisser quelques informations...</h1>
        <div class=news>
            <form action="minichat_saisie_info_visiteur_post.php" method="post">
                <p>
                    <strong>Pseudo  :</strong> 
                    <?php 
                        echo $_SESSION['mnc_pseudo']; 
                    ?>  
                    <br/>
                    Mot de passe : <input type="password" name="mdp2" maxlength="80" required />
                    <br/>
                    <?php echo 'Prénom : <input type="text" name="prenom"  maxlength="80" value="'.$_SESSION['mnc_prenom'].'" required />';
                    ?>
                    <br/>
                    <?php echo 'Nom : <input type="text" name="nom"  maxlength="80" value="'.$_SESSION['mnc_nom'].'"  required />';
                    ?>
                    <br/>
                    <?php echo 'Adresse email: <input type="text" name="ad_mail"   maxlength="80" value="'.$_SESSION['mnc_ad_mail'].'" required />';
                    ?>
                    <br/>
                    <strong>Validez vos informations : </strong><input type="submit" name="envoyer" value="Envoyer" />
                </p>
            </form>
        </div>
    </body>
</html>


