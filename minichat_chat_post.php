<?php
/*
DESCRIPTION
    DONNEES D'ENTREE
        BD minichat
        date courrante
        les variables url GET
            l'identifiant du thème position dans la page se sélection de thème
            la page de 5 message à afficher positionner dans la page minichat_chat elle même 
        les variables de POST:
            le contenu du message saisi
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
if (!( isset($_POST['message']) AND isset($_POST['envoyer']) ) ) {
    header('location: index.php');
}
else{
    // Echappement ("escaping" in english) des variables saisies au clavier
    $_SESSION['mnc_mcontenu'] = htmlspecialchars($_POST['message']);
    
    // Vérification cohérence inputs

    // Echappement des autres champs
    $_SESSION['mnc_date_reception']=date('Y-m-d h:i:s',time());
    // Connexion à la base de données minichat
    try{$bdd = new PDO('mysql:host=localhost;dbname=minichat','root','', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e) {die('Erreur :' . $e->getMessage());
    }

    // Recherche dans la BD minichat l'existence du pseudo saisi par le visiteur
    $qry = 'INSERT INTO
                messages (
                    id_visiteur,
                    id_theme,
                    contenu,
                    date_reception
                )
            VALUES (
                :idv,
                :idt,
                :contenu,
                :daterecepetion
            )'   
            ;

echo var_dump($qry);
echo var_dump($_SESSION);

    // Préparation de la requète
    $requete = $bdd->prepare($qry);
    $requete->execute(
                array(
                    'idv'=>$_SESSION['mnc_id_visiteur'],
                    'idt'=>$_SESSION['mnc_theme_id'],
                    'contenu'=>$_SESSION['mnc_mcontenu'],
                    'daterecepetion'=>$_SESSION['mnc_date_reception']
                    )
                );


    $requete->closeCursor(); 
    header('location: minichat_chat.php');
}
?>
