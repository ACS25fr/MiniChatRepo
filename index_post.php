<?php
/*
DESCRIPTION:
  DONNEES D'ENTREE
    - pseudo: pseudo du visiteur (type POST)
    - mdp : mot de passe du visiteur (type POST)
  TRAITEMENT:
    Séquence 
      - échappement ("escaping") des données d'entrées
      - Recherche du pseudo saisi dans la BD minichat
      - Si le speudo n'existe pas, lancement de la page de saisie des info visiteur
      - Sinon 
          - Vérification de la correspondance du mot de passe saisi avec celui de la BD minichat associé au pseudo
          - Si le mot de passe n'existe pas, retour à la page index avec effacement des variables de session du pseudo et du mot de passe (N.B.: il peut y avoir autant d'erruer de saisi dans le pseudo que dans le mot de passe).
          Sinon
              Lancement de la page de selection du theme de discussion
    Pour information:        
    - affichage de la fréquentation du blog: liste par 5 des titres de theme les plus fréquentés avec leurs nombres de messages respectifs
  RESULTATS:
    - Lancement de la page de saisie des info visiteur
    - ou, Retour à la page index pour une nouvelle saisie du mot de passe 
    - ou, Lancement de la page de sélection d'un tème de discussions
*/

// Démarrage session
session_start();
 
//Vérification de la saisie du visiteur
if (!(isset($_POST['pseudo']) AND isset($_POST['mdp'])  ) ) {
  header('location: index.php');
}
else
{
 // Echappement ("escaping") des variables saisies au clavier
  $_SESSION['mnc_pseudo']=htmlspecialchars($_POST['pseudo']);
  $_SESSION['mnc_mdp']=htmlspecialchars($_POST['mdp']);

   // Connexion à la base de données minichat
  try{ $bdd = new PDO('mysql:host=localhost;dbname=minichat','root','', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
  }
  catch (Exception $e) { die('Erreur :' . $e->getMessage());
  }
  // Recherche dans la BD minichat l'existence du pseudo saisi par le visiteur
  $qry = 'SELECT
            COUNT(v.pseudo) cvpseudo
          FROM
            visiteurs v
          WHERE
              v.pseudo = :pseudo';
  
  // Préparation de la requète
  $requete = $bdd->prepare($qry);
  $requete->execute(array(':pseudo'=>$_SESSION['mnc_pseudo']));
  $donnees = $requete->fetch();
  $cvpseudo=(int)$donnees['cvpseudo'];

 // Si le pseudo n'existe pas,
  if ($cvpseudo<1) {
      // ouverture de la page de saise des info visiteur
      $requete->closeCursor(); 
      header('location: minichat_saisie_info_visiteur.php');
  }
  // Sinon si le pseudo existe et n'est pas unique,
  elseif ($cvpseudo>1){
    //Effacement du pseudo saise et retour à la page index
    // N.B. : ce cas ne devrait jamais se présenter : le champ "pseudo" de la table "visiteurs" est configuré unique au sein de la base minichat.sql
    $_SESSION['mnc_pseudo']='';
    $requete->closeCursor(); 
    header('location: index.php');    
  }
  // Sinon le pseudo existe et est unique.
  else{
    //Comparaison du mot de passe saisi avec celui enregistré dans la BD minichat correspondant au visiteur courant, et récupération des info de la base pour enregistrement dans les variables de session si le tests de correspondance des mots de passe est satifaisant
    $qry2 = 'SELECT
              v.id vid,
              v.pseudo vpseudo,
              v.nom vnom ,
              v.prenom vprenom ,
              v.ad_mail vadmail
            FROM
              visiteurs v
            WHERE
                v.pseudo = :pseudo AND v.mdp = :mdp';
    // Préparation de la requète
    $requete = $bdd->prepare($qry2);
    $requete->execute(array(':pseudo'=>$_SESSION['mnc_pseudo'],':mdp'=>$_SESSION['mnc_mdp']));
    
    $donnees2 = $requete->fetch();
    
    // Si le mot de passe n'existe pas ( Le pseudo étant testé existant, si un critère de sélection sur le pseudo et son mot de passe associé ne renvoie pas d'enregistrement, alors le mot de passe saisi n'est pas le bon) 
    if ($donnees2['vpseudo'] == NULL){

        // On efface tout et on recommence: retour à la page index
        $_SESSION['mnc_pseudo']='';
        $_SESSION['mnc_mdp']='';
        $requete->closeCursor(); 
        header('location: index.php');
    }
    else{
     // Le pseudo existe dans la base minichat et le mot de passe saisi correspond au pseudo, alors on peut Ouvrir la sélection du thème.
      // mettre à jour les variable de session et lancer la selection des thèmes 
      $_SESSION['mnc_id_visiteur']=$donnees2['vid'];
      $_SESSION['mnc_prenom']=$donnees2['vprenom'];
      $_SESSION['mnc_nom']=$donnees2['vnom'];
      $_SESSION['mnc_ad_mail']=$donnees2['vadmail'];
      $requete->closeCursor(); 
      header('location: minichat_select_theme.php');
    }     
  }
}
?>
