<?php
/*
DESCRIPTION
    DONNEES D'ENTREE
        -Variables _POST :
            - mot de passe pour confirmation  (required)
            - Prénom
            - Nom
            - Adresse mail (required)
        - Variables de session:
            - Pseudo
            - mot de passe
    TRAITEMENT:
    Echappement de la confirmation du mot de passe saisi (POST)
    Si la confimation du mot de passe (POST) ne correspond pas au mot de passe (session) retour au formulaire (same player shot again)
    sinon
        Echappement des autres informations POST et enregistrement en variable de SESSION
        INsertion des donnees visiteur dans la BD minichat, table visiteurs
        lancement de la page de sélection d'un thème de discussion
    RESULTATS:
    Insertion des données visiteurs dans le BD minichat, table visiteurs
    lancement de la page de sélection d'un thème
*/

// Démarrage session
session_start();

//Vérification de la saisie du visiteur
if (!( isset($_POST['mdp2']) AND isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['ad_mail'])) ) {
    header('location: index.php');
}
else{
    // Echappement ("escaping" in english) des variables saisies au clavier
    $_SESSION['mnc_mdp2'] = htmlspecialchars($_POST['mdp2']);
    $_SESSION['mnc_prenom'] = htmlspecialchars($_POST['prenom']);
    $_SESSION['mnc_nom'] = htmlspecialchars($_POST['nom']);
    $_SESSION['mnc_ad_mail'] = htmlspecialchars($_POST['ad_mail']);
    
    // Vérification de la confirmation du mot de passe
    if(!($_SESSION['mnc_mdp']==$_SESSION['mnc_mdp2'])){
       //lancer le formulaire de saise des info visiteur
       header('location: minichat_saisie_info_visiteur');
    }
    else{
        // Echappement des autres champs
        $_SESSION['mnc_prenom'] = htmlspecialchars($_POST['prenom']);
        $_SESSION['mnc_nom'] = htmlspecialchars($_POST['nom']);
        $_SESSION['mnc_ad_mail'] = htmlspecialchars($_POST['ad_mail']);
        
        // Connexion à la base de données minichat
        try{$bdd = new PDO('mysql:host=localhost;dbname=minichat','root','', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e) {die('Erreur :' . $e->getMessage());
        }

        // Recherche dans la BD minichat l'existence du pseudo saisi par le visiteur
        $qry = 'INSERT INTO
                    visiteurs (
                        pseudo,
                        mdp,
                        nom,
                        prenom,
                        ad_mail
                    )
                VALUES (
                    :pseudo,
                    :mdp,
                    :nom,
                    :prenom,
                    :ad_mail
                )'   
                ;
        // Préparation de la requète
        $requete = $bdd->prepare($qry);
        $requete->execute(
                    array(
                        ':pseudo'=>$_SESSION['mnc_pseudo'],
                        ':mdp'=>$_SESSION['mnc_mdp'],
                        ':nom'=>$_SESSION['mnc_nom'],
                        ':prenom'=>$_SESSION['mnc_prenom'],
                        ':ad_mail'=>$_SESSION['mnc_ad_mail']
                        )
                    );
        $requete->closeCursor(); 
        header('location: minichat_select_theme.php');
    }
}

?>
