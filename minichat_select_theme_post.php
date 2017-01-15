<?php
/*
DESCRIPTION
    DONNEES D'ENTREE
        BD minichat
        date courrante
        les variables de POST:
            Titre du thème saisi
            contenu du thème saisi
        les variables de session:
    TRAITEMENT
        test des variable POST
        escaping des variable POST
        Enregistement en variables de session des données de thème saisies
        Insertion du thème dans la DB
    RESULTATS
        Enregistrement du thème saise dans la DB minichat
*/      

// Démarrage session
session_start();
 
//Vérification de la saisie du visiteur
if (!( isset($_POST['ttitre']) AND isset($_POST['tcontenu']) AND isset($_POST['creer']) ) ) {
    header('location: index.php');
}
else{
    // Echappement ("escaping" in english) des variables saisies au clavier
    $_SESSION['mnc_ttitre'] = htmlspecialchars($_POST['ttitre']);
    $_SESSION['mnc_tcontenu'] = htmlspecialchars($_POST['tcontenu']);
    
    // Vérification cohérence inputs

    // Echappement des autres champs
    $_SESSION['mnc_tdate_creation']=date('Y-m-d h:i:s',time());

    // Connexion à la base de données minichat
    try{$bdd = new PDO('mysql:host=localhost;dbname=minichat','root','', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e) {die('Erreur :' . $e->getMessage());
    }

echo $_SESSION['mnc_ttitre'];
echo $_SESSION['mnc_tcontenu'];


    // Recherche dans la BD minichat l'existence du pseudo saisi par le visiteur
    $qry = 'INSERT INTO
                themes (
                    titre,
                    contenu,
                    date_creation,
                    id_visiteur
                )
            VALUES (
                :ttitre,
                :tcontenu,
                :tdate_creation,
                :tid_visiteur
            )'   
            ;
    // Préparation de la requète
    $requete = $bdd->prepare($qry);
    $requete->execute(
                array(
                    'ttitre'=>$_SESSION['mnc_ttitre'],
                    'tcontenu'=>$_SESSION['mnc_tcontenu'],
                    'tdate_creation'=>$_SESSION['mnc_tdate_creation'],
                    'tid_visiteur'=>$_SESSION['mnc_id_visiteur']
                    )
                );


    $requete->closeCursor(); 
    header('location: minichat_select_theme.php');
}
?>
