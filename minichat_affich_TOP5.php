<?php
/*
DESCRIPTION:
    DONNEES D'ENTREE
        - BD minichat
    TRAITEMENT:
        Requete:
            - liste des 5 thèmes les plus récemment fréquentés(date de dernier messages) et les plus fréquentés(nb messages)
        Affichage:
           pour chaque thème:
            Titre du thème
            Contenu du thème
            date du dernier message du thème
            nombre de message du thème
    RESULTATS:
        - L'affichage TOP5
        - Le message base de données vide de thème
*/
  // Connexion à la base de données minichat
  try{ $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
  }
  catch(Exception $e) { die("Erreur : ".$e->getMessage());
  }
  
  // Affichage du top 5 des thèmes en term de fréquentation:
  // Requète sélection
  $qry =  'SELECT
            t.titre ttitre,
            t.contenu tcontenu,
            COUNT(m.id) cmid,
            MAX(m.date_reception) mmdr
          FROM
            themes t
          JOIN
            messages m
          ON
            t.id = m.id_theme
          GROUP BY
            t.id
          ORDER BY
            mmdr DESC, cmid DESC  
          LIMIT 0, 5';
  
  // Execution de la requète
  $reponse = $bdd->query($qry);
  
  // Affichage du thème
  if ($reponse) {
      while($donnees = $reponse->fetch()){
          ?><strong>
          <?php
          echo mb_strtoupper(htmlspecialchars($donnees['ttitre']));
          ?>
          </strong>
          <?php
          echo ' - '.htmlspecialchars($donnees['tcontenu']);
          echo ' - '. $donnees['cmid'].' msg<br><br>';
      }
      $reponse->closeCursor();
  }
  else{
      echo "Aucun message, voire aucun thème,  les tables sont vides!";
  }
?>