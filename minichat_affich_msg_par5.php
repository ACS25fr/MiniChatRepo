<?php
// DONNEES D'ENTREE :
// $_SESSION['mnc_entete_page_msg'] : Rang dans la sélection du 1er message à afficher
//
// TRAITEMENT:
// Sélection 
//
// RESULTAT:
// Affiche par 5  les messages dans l'ordre chronologique inverse à partir du rang


  // Connexion à la base de données minichat
  try{ $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
  }
  catch(Exception $e) { die("Erreur : ".$e->getMessage());
  }
  
  // Sélection par 5 des messages du theme courant par ordre chronolgique inverse :
  // Requète sélection
  $qry =  
    'SELECT
      m.date_reception mdr,
      m.contenu mcontenu
    FROM
      messages m
    JOIN
      themes t
    ON
      t.id = m.id_theme
    WHERE
      t.id = '.$_SESSION['mnc_theme_id'].
    ' ORDER BY
      m.date_reception
    DESC
    LIMIT '.
    (string)$_SESSION['mnc_entete_page_msg'].' , 5';
  // Execution de la requète
  $reponse = $bdd->query($qry);  

  if ($reponse ){
    while($donnees = $reponse->fetch()){
      ?><strong>
      <?php
      echo date("d.M.Y H:i:s", strtotime(htmlspecialchars($donnees['mdr'])));
     ?>
      </strong>
      <?php
      echo ' - '.htmlspecialchars($donnees['mcontenu']).'<br><br>';
    }
    $reponse->closeCursor();
  }
  else{
    echo ' Probable problème de requète SQL ou absence de message dans le thème courant ';
  }  
?>