<?php
/*
DESCRIPTION:
    DONNEES D'ENTREE
        - BD minichat
        - cookie du pseudo
    TRAITEMENT:
        Formulaire:
            - input: saisie du pseudo avec prépositionnement avec le dernier pseudo saisi correctement avec son mot de passe
            - input: saisie du mot de passe
            - bouton: validation de la saisie
            - zone texte: affichage du TOP5 des Thème (vitrine du blog): liste par 5 des titres et contenus de theme les plus récemment fréquentés(date de dernier message) puis les plus fréquentés (nombre de messages)
    RESULTATS:
        - Lancement du traitement POST avec les paramètres  pseudo et mot de passe saisis et validés
        - Affichage du TOP5
*/
// Démarrage session
session_start();

// Positionner les variables propre à la session
include 'minichat_init_var_session.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="index.css" rel="stylesheet" />
        <title>Minichat avec thèmes.</title>
    </head>
    <body>
        <h1>Mini Chat, le super blog !
        </h1>
        <div class=news>
            <form action="index_post.php" method="post">
                <p>
                    <?php echo '<strong>Pseudo</strong> : <input type="text" name="pseudo" maxlength="80" value= "'.$_SESSION['mnc_pseudo'].'" required />'; 
                    ?>
                    <br/>
                    <strong>Mot de passe</strong> : <input type="password" name="mdp"  maxlength="80" required />
                    <br/>
                    <label for="envoyer">Cliquez pour envoyer</label> : <input type="submit" name="envoyer" value="Envoyer" />
                    <br />
                </p>
            </form>
            <h3>
            <?php
                // Affichage des thèmes TOP5 du blog MiniChat
                include 'minichat_affich_TOP5.php';
            ?>
            </h3>
        </div>  
    </body>
</html>   

