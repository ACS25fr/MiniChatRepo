<?php
/*
DESCRIPTION
    DONEES D'ENTREE
        DB minichat
        les variables de session:

        Les variables de formulaire

    TRAITEMENT
        Affiche la liste des thèmes triée par ordre chronologie inverse afin qu'un thème nouvellmeent créer apparaisse dans la liste immédiatement. 
        Calcul le nombre de thèmes de la BD et en définit la menu de pagination de la table trièe des thèmes

    RESULTATS
        Liste trièes des thèmes
        Menu de pagination avec retour a la page index et la touche quitter le blog
*/
        
// Démarrage session
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="index.css" rel="stylesheet" />
        <title>Minichat avec thèmes.</title>
    </head>
    <body>
        <h1>Mini Chat, le choix des thèmes !</h1>
        <div class=news>
            <form action="minichat_select_theme_post.php" method="post">
                <p>
                    <?php 
                        $str= 
                        'Bonjour <strong>'.$_SESSION['mnc_prenom'].'</strong> ! Créez ou sélectionner un thème.<br>
                        Votre pseudo : <strong>'.$_SESSION['mnc_pseudo'].'</strong><br>';
                        echo $str;
                    ?>
                    <label class="ttitre" for="ttitre">Titre du thème</label> : <input type="text" name="ttitre"  maxlength="80" required /> Contenu :<br /> 
                    <textarea name="tcontenu" rows="5" cols="40" spellcheck autofocus required> </textarea>
                    <label for="creer"><br />Cliquez pour </label><input type="submit" name="creer" value="Créer" /> le nouveau thème.
                    <br />
                </p>
            </form>

            <footer>
                <?php
                // Compte le nombre de thèmes de la DB Minichat
                include 'minichat_count_themes.php';
                // Affichage de la barre de navigation
                echo '<a href="index.php"> [Retour] </a>';
                echo '<a href="exit.php"> [Quitter] </a>';
                echo '<br>';
                if ((int)$_SESSION['nb_themes']>=5){
                    ?>
                    Selection des pages de thèmes:
                    <?php
                    for ($i=0, $j=1; $i < ((int)$_SESSION['nb_themes']); $i+=5,$j++){
                        echo '<a href="minichat_select_theme.php?&page='.(string)$j.'"> ['.(string)$j.']</a>' ;
                    }
                }
                ?>  
            </footer>
            <h3>
            <?php
                // Gestion de la page à afficher
                if (isset($_GET['page'])){
                    $_SESSION['mnc_num_page_themes']= ((int)htmlspecialchars($_GET['page']))-1;
                }
                else // sinon pointer sur la première page
                {
                    $_SESSION['mnc_num_page_themes']=0;
                }

                // L'index du 1er thème de la liste affichée est:
                $_SESSION['mnc_entete_page_themes']=$_SESSION['mnc_num_page_themes']*5;
                
                include 'minichat_affich_theme_par5.php';      
            ?>
            </h3>
            
            

        </div> 
                
    </body>
</html>   

