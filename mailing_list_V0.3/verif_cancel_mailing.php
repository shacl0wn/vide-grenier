<?php
session_start();

if ($_POST['mailCancel'] != "") {

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Désinscription Mailing Liste | CIL de la Gravière</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
</head>

<body>
    <?php
    include 'inc_header.php';
    ?>

    <?php

    try {
        include 'inc_bdd.php';

        // Test mailing existent 
        $mail = htmlspecialchars($_POST['mailCancel']);


        $resultat_select = $base->prepare("CALL call_user_mailing_list(?)");

        $resultat_select->bindParam(1, $mail, PDO::PARAM_STR);
        $resultat_select->execute();

        //On test si un résultat est retourné
        if (!empty($resultat_select)) {

//          Nouvelle partie avec la procedure stocké
            $resultat_insert = $base->prepare("CALL delete_user_mailing_list2(?)");

            $resultat_insert->bindParam(1, $mail, PDO::PARAM_STR);
            $resultat_insert->execute();
            echo "<section id=\"mailingValidée\" class = \"boxSite\">Votre Désinscription est validée<br/>
        <a class=\"nav-link\" href=\"accueil.php\">Accueil</a></section>";
            
        } else {

            
        header("Location:mailing_list.php?erreur_cancel_mailing=" . urlencode("*Cette adresse e-mail n'est pas utilisée"));
        }
    } catch (Exception $e) {

        die('Erreur : ' . $e->getMessage());
    } finally {

        $base = null; //fermeture de la connexion
    }
    ?>

    <?php
    include 'inc_footer.php';
    ?>

    <script src="../js/jquery-3.5.0.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/myscript.js"></script>
</body>

</html>

<?php
} else {

    header("Location:accueil.php");
}
?>