<?php

    // Connexion à la base de données minichat
    try{ $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
    }
    catch(Exception $e) { die("Erreur : ".$e->getMessage());
    }

    // Affichage du thème le plus récemment visité sur le blog avec:
    // Titre - Contenu - Pseudo du visiteur(auteur) - Date de création du thème 
    // Requète sélection
    $qry1 = "SELECT
                t.titre ttitre,
                t.contenu tcontenu,
                v.pseudo vpseudo,
                t.date_creation tdate_creation,
                t.id tid
            FROM
              themes t
            JOIN
              messages m
            ON
              t.id = m.id_theme
            JOIN
              visiteurs v
            ON
              v.id = t.id_visiteur
            ORDER BY
              m.date_reception
            DESC
            LIMIT 0, 1";

    // Execution de la requète
    $reponse1 = $bdd->query($qry1);

    // Affichage du thème
    if ($reponse1) {
        $donnees1 = $reponse1->fetch();
        
        echo htmlspecialchars($donnees1["ttitre"])." - ". nl2br(htmlspecialchars($donnees1["tcontenu"]),true)
        ." - Posté par : ". $donnees1["vpseudo"].", le : ". $donnees1["tdate_creation"]."<br>";
        
        // Libération du pointeur de BD
        $reponse1->closeCursor();
    }
    else{
        echo "Aucun résultat à la requète sélection (Table vide)";
    }
?>