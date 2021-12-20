<?php
session_start();

if (isset($_SESSION['id_util']) && $_SESSION["admin"] == 1) {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des utilisateurs | CIL de la Gravière</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/monstyle.css">
    </head>

    <body>
        <?php
        include 'inc_header.php';
        ?>
        <main id="listeUtil">
            <?php

            try {
                include 'inc_bdd.php';

                // Nbr utilisateurs pour pagination
                $countUtil = "SELECT COUNT(*) FROM utilisateur";

                $resultatCount = $base->prepare($countUtil);

                $resultatCount->execute();
                $nbrUtil = $resultatCount->fetchColumn();
                $nbrPage = (int) ($nbrUtil / 25) + 1;

                if (isset($_GET['page'])) {

                    $page = $_GET['page'];
                } else {

                    $page = 1;
                }

                $nbrLigneBase = ($page - 1) * 3;


                // Un admin ne peut voir les autres admin
                $select_util =  "SELECT * FROM utilisateur WHERE id_role != 1 LIMIT $nbrLigneBase, 25";

                $resultat_select = $base->prepare($select_util);
                $resultat_select->execute();

                $table = "<table class=\"table table-striped\"><tr><th>Mail</th><th>Nom</th><th>Prenom</th><th>Telephone</th><th>Description</th><th class=\"text-center\">Supprimer Utilisateur</th></tr>";

                while ($ligne = $resultat_select->fetch()) {

                    $table .= "<tr><td>" . $ligne['mail_util'] . "</td><td>" . $ligne['nom_util'] . "</td><td>" . $ligne['prenom_util'] . "</td><td>" . $ligne['tel_util'] . "</td><td>" . $ligne['desc_util'] . "</td><td class=\"text-center\"><input type=\"radio\" id=\"" . $ligne['id_util'] . "\" name=\"choix\" value=\"" . $ligne['id_util'] . "\"></td></tr>";
                }

                $table .= "</table>";
                echo "<section class = \"boxSite\">";
                echo "<form method=\"POST\" action=\"admin_erase_util.php\" id=\"formSupp\">";
                echo $table;
                echo "<div class=\"text-center\"><button class=\"bouton\" type=\"submit\">Supprimer</button></div></form>";
                


                echo "<section class=\"row\" id=\"suivantPrecedent\">";

                if ($page != 1) {

                    echo "<div class=\"text-left col-md-6\"><a class=\"bouton\" href=\"admin_util.php?page=" . ($page - 1) . "\"><--</a></div>";
                } else {

                    echo "<div class=\"text-left col-md-6\"></div>";
                }

                if ($page != $nbrPage) {

                    echo "<div class=\"text-right col-md-6\"><a class=\"bouton\" href=\"admin_util.php?page=" . ($page + 1) . "\">--></a></div>";
                } else {

                    echo "<div class=\"text-right col-md-6\"></div>";
                }

                echo "</section>";

                echo "<div id=\"erreurSupp\" class=\"red\">";
                if (isset($_GET["erreur_supp"])) {

                    echo $_GET["erreur_supp"];
                }

                echo "</div>";

                echo "</section>";
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