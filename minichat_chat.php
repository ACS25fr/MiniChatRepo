<?php
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
        <h1>Mini Chat, c'est à vous !</h1>
        <div class=news>
            <form action="minichat_chat_post.php" method="post">
                <p>
                    <?php 
                        $str= 
                        '<strong>'.$_SESSION['mnc_prenom'].'</strong> ! Participez en entrant votre message.
                        <br>Votre pseudo : <strong>'.$_SESSION['mnc_pseudo'].'</strong><br>';
                        echo $str;
                    ?>
                    <label class="msg" for="message">Nouveau message</label> :<br /> 
                    <textarea name="message" rows="5" cols="40" spellcheck autofocus> </textarea>
                    <label for="envoyer"><br />Cliquez pour </label><input type="submit" name="envoyer" value="Envoyer" /> le nouveau message.
                    <br />
                </p>
            </form>

        <footer>
                <?php
                // Compte le nombre de messages du thème choisi
                if (isset($_GET['themeid'])){
                    $_SESSION['mnc_theme_id']= (int)htmlspecialchars($_GET['themeid']);
                }
                include 'minichat_count_msgdutheme.php';

                // Affichage de la barre de navigation
                echo '<a href="minichat_select_theme.php"> [Retour] </a>';
                echo '<a href="exit.php"> [Quitter] </a>';
                echo '<br>';
                if ($_SESSION['mnc_nb_msg']>=5){
                    ?>
                    Selection des pages de messages:
                    <?php
                    for ($i=0, $j=1; $i < $_SESSION['mnc_nb_msg']; $i+=5,$j++){
                        echo '<a href="minichat_chat.php?&themid='.$_SESSION['mnc_theme_id'].'&page='.(string)$j.'"> ['.(string)$j.']</a>' ;
                    }
                }
                ?>  
            </footer>

            <h3>
                <?php
                    // Gestion de la page à afficher
                    if (isset($_GET['page'])){
                        $_SESSION['mnc_num_page_msg']= ((int)htmlspecialchars($_GET['page']))-1;
                    }
                    else // sinon pointer sur la première page
                    {
                        $_SESSION['mnc_num_page_msg']=0;
                    }
                    // L'index du 1er message de la liste affichée est:
                    $_SESSION['mnc_entete_page_msg']=$_SESSION['mnc_num_page_msg']*5;

                    include 'minichat_affich_msg_par5.php'; 
                ?>
            </h3>
            <p>
            
                <?php
                ?>
                
            </p>
            
        </div>
                
    </body>
</html>   

