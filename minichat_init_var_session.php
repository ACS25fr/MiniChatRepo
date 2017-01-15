<?php
// Initialisation des variable de session          

// Positionner les variables de sessions à partir des cookies Mini Chat (mnc)
// pseudo visiteur courant
if (empty($_SESSION['mnc_pseudo'])){
    if (isset($_COOKIE['mnc_pseudo'])){
        $_SESSION['mnc_pseudo'] = htmlspecialchars($_COOKIE['mnc_pseudo']);
    }
    else{
        $_SESSION['mnc_pseudo'] = '';
    }
}
// identifiant du visiteur courant
if (empty($_SESSION['mnc_id_visiteur'])){
    $_SESSION['mnc_id_visiteur']=0;
}
// mot de passe du visiteur courant
if (empty($_SESSION['mnc_mdp'])){
    $_SESSION['mnc_mdp']='';
}
// Confirmation mot de passe du visiteur courant
if (empty($_SESSION['mnc_mdp2'])){
    $_SESSION['mnc_mdp2']='';
}
// prénom visiteur courant
if (empty($_SESSION['mnc_prenom'])){
    $_SESSION['mnc_prenom']='';
}
// Nom visiteur courant
if (empty($_SESSION['mnc_nom'])){
    $_SESSION['mnc_nom']='';
}
// Adresse mail du visiteur courant
if (empty($_SESSION['mnc_ad_mail'])){
    $_SESSION['mnc_ad_mail']='';
}
// Identifiant du dernier thème consulté par le visiteur courant
if (empty($_SESSION['mnc_der_theme_id'])){
    $_SESSION['mnc_der_them_id']= 0;
}
// Date du dernier message reçu du visiteur courant
if (empty($_SESSION['mnc_der_msg_date'])){
    $_SESSION['mnc_der_msg_id']= 0;
}

// Nombre de thèmes
if (empty($_SESSION['mnc_nb_themes'])){
    $_SESSION['mnc_nb_themes']= 0;
}
// Numéro de page de thèmes courante
if (empty($_SESSION['mnc_num_page_themes'])){
    $_SESSION['mnc_num_page_themes']= 0;
}
// Identifiant du thème courant
if (empty($_SESSION['mnc_theme_id'])){
    $_SESSION['mnc_theme_id']= 0;
}
// Nombre de message du thème courant
if (empty($_SESSION['mnc_nb_msg'])){
    $_SESSION['mnc_nb_msg']= 0;
}
// Numéro de page de messages curante
if (empty($_SESSION['mnc_num_page_msg'])){
    $_SESSION['mnc_num_page_msg']= 0;
}

?>

