<?php
session_start();

if(isset($_SESSION['id_util']) && $_SESSION["admin"] == 1 && $_POST['label'] != "" && $_POST['date'] != "" && $_POST['heure'] != "" && $_POST['addresse'] != "" && $_POST['nombre'] != "" && $_POST['prix'] != ""){
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Programmation | CIL de la Gravière</title>
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

        $label = htmlspecialchars($_POST['label']);
        $date = htmlspecialchars($_POST['date']);
        $heure = htmlspecialchars($_POST['heure']);
        $addresse = htmlspecialchars($_POST['addresse']);
        $cp = htmlspecialchars($_POST['cp']);
        $ville = htmlspecialchars($_POST['ville']);
        $nombre = htmlspecialchars($_POST['nombre']);
        $prix = htmlspecialchars($_POST['prix']);

        //Conversion de la date en format "date" pour la bdd
        $old_date = strtotime($date);
        $new_date = date("Y-m-d", $old_date);



        $insert_vg =  "INSERT INTO vide_grenier (lib_vg, date_vg, heure_vg, adr_vg, cp_vg, ville_vg, nbEmpl_vg, nbEmplRestant_vg, prixEmpl_vg) VALUES (:label, :date_vg, :heure, :addresse, :cp, :city, :nbr, :nbr_restant, :prix)";

        $resultat_insert = $base->prepare($insert_vg);

        $resultat_insert->bindParam(':label', $label);
        $resultat_insert->bindParam(':date_vg', $new_date);
        $resultat_insert->bindParam(':heure', $heure);
        $resultat_insert->bindParam(':addresse', $addresse);
        $resultat_insert->bindParam(':cp', $cp);
        $resultat_insert->bindParam(':city', $ville);
        $resultat_insert->bindParam(':nbr', $nombre);
        $resultat_insert->bindParam(':nbr_restant', $nombre);
        $resultat_insert->bindParam(':prix', $prix);
        $resultat_insert->execute();

        
            echo "<section id=\"progValidée\" class=\"boxSite\">Vide-grenier programé!<br/>
        <a class=\"nav-link\" href=\"panneau_admin.php\">Retour</a></section>";
        
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
    header("Location:accueil.php?erreur_prog=" . urlencode("*Une erreur est survenue, veuillez recommencer."));
}
?>