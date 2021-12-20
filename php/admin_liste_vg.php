<?php
session_start();

if (isset($_SESSION['id_util']) && $_SESSION["admin"] == 1) {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des vide-greniers | CIL de la Gravière</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/monstyle.css">
    </head>

    <body>
        <?php
        include 'inc_header.php';
        ?>
        <main id="listeVG">


            <?php
            if (isset($_GET["erreur_prog"])) {
                echo "<div id=\"erreurUpdateVG\" class=\"red boxSite\">";
                echo $_GET["erreur_prog"];
                echo "</div>";
            }

            try {
                include 'inc_bdd.php';

                $select_vg =  "SELECT * FROM vide_grenier";

                $resultat_select = $base->prepare($select_vg);
                $resultat_select->execute();


                while ($ligne = $resultat_select->fetch()) {

                    $table = "<table class=\"table table-striped\" id=\"" . $ligne['id_vg'] . "\"><tr><th>Label</th><th>Date</th><th>Heure</th><th>Adresse</th><th>Emplacement</th><th>Emplacement Restant</th><th>Prix</th></tr>";
                    $table .= "<tr><td>" . $ligne['lib_vg'] . "</td><td>" . $ligne['date_vg'] . "</td><td>" . $ligne['heure_vg'] . "</td><td>" . $ligne['adr_vg'].' '.$ligne['cp_vg'].' '.$ligne['ville_vg'] . "</td><td>" . $ligne['nbEmpl_vg'] . "</td><td>" . $ligne['nbEmplRestant_vg'] . "</td><td>" . $ligne['prixEmpl_vg'] . "</td></tr>";
                    $table .= "</table>";
                    echo "<section class = \"boxSite\">" . $table;
                    echo "<div><a href=\"admin_update_vg.php?idVG=" . $ligne['id_vg'] . "\" class=\"bouton\">Modifier</a></div>";
                    echo "</section>";
                }
            } catch (Exception $e) {

                die('Erreur : ' . $e->getMessage());
            } finally {

                $base = null; //fermeture de la connexion
            }
            ?>


        </main>
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