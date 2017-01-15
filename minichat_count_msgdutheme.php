<?php


  // Connexion à la base de données minichat
  try{ $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
  }
  catch(Exception $e) { die("Erreur : ".$e->getMessage());
  }
  
  // Comptage des thèmes
  // Requète sélection
  $qry =  'SELECT COUNT(m.id) AS cmid
          FROM 
            messages m
          JOIN 
            themes t
          ON 
            t.id = m.id_theme 
          WHERE
            t.id = '.$_SESSION['mnc_theme_id'];

  // Execution de la requète
  $requete= $bdd->query($qry);

  // Si le pseudo n'existe pas,
  $donnees = $requete->fetch();
  if ($donnees!=NULL) {
    $_SESSION['mnc_nb_msg'] = (int)$donnees['cmid'];
  }
  $requete->closeCursor(); 
?>