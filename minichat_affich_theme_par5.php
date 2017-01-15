<?php
/*
DESCRIPTION
  DONNEES D'ENTREE :
    DB minichat
    S_SESSION['mnc_entete_page_themes'] : Rang dans la sélection du 1er thème à afficher

  TRAITEMENT:
    Requète sur DB minichat sélectionnant:
      les composants de la ligne descriptive du thème à savoir:
        - titre du thème
        - la date de creation du thème
        - le contenu du thème
        - le nombre de messages du thème
        - la date du message le plus récent du thème, si le thème contient des messages
      l'identifiant du thème pour posiionner la 1ère variable de POST de la page suivante minichat_chat.
  RESULTATS
    Affichage des 5 derniers thèmes 
    lancement de la page minichat_chat
*/

  // Connexion à la base de données minichat
  try{ $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
  }
  catch(Exception $e) { die("Erreur : ".$e->getMessage());
  }
  
  // Affichage par 5 les thèmes les plus récent, les plus récemment alimentés en messages et le plus alimentés :
  // Requète sélection
  $qry =  'SELECT 
            t.id tid,        
            t.titre ttitre,
            t.contenu tcontenu,
            t.date_creation tdatecreation,
            MAX(m.date_reception) mmdr,
            COUNT(m.id) cmid
          FROM 
            themes t 
          LEFT JOIN 
            messages m 
          ON 
            t.id = m.id_theme 
          GROUP BY 
            t.id 
          ORDER BY 
            tdatecreation DESC,
            mmdr DESC,
            cmid DESC
          LIMIT ' . (string)$_SESSION['mnc_entete_page_themes'].' , 5';
  // Execution de la requète
  $reponse = $bdd->query($qry);  

  if ($reponse ){
    while($donnees = $reponse->fetch()){
      ?><strong>
      <?php
      echo mb_strtoupper(htmlspecialchars($donnees['ttitre']));
      echo '( '.date('d.M.Y', strtotime(htmlspecialchars($donnees['tdatecreation']))).' )';
      ?>
      </strong>
      <?php
      echo ' - '.htmlspecialchars($donnees['tcontenu']);
      echo ' - ( '. htmlspecialchars($donnees['cmid']).' msg ) - ';
      if ($donnees['cmid']<>0)  echo date("d.M.Y", strtotime(htmlspecialchars($donnees['mmdr'])));
      echo '  >>  <a href="minichat_chat.php?&themeid='.htmlspecialchars($donnees['tid']).'&page=1">Chat</a><br><br>';
    }
    $reponse->closeCursor();
  }
  else{
    echo ' Probable problème de requète SQL ou de table vide ';
  }  
?>