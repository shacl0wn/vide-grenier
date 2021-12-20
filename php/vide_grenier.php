<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vide Grenier | CIL de la Gravière</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
</head>

<body>
    <?php
    include 'inc_header.php';

    try {
        include 'inc_bdd.php';

        $select_vg = 'SELECT * FROM vide_grenier ORDER BY date_vg DESC';
        $resultat = $base->prepare($select_vg);

        $resultat->execute();

        echo "<main id=\"videGrenier\" class=\"text-center\">";

        while ($ligne = $resultat->fetch()) {

            $id = $ligne['id_vg'];
            $label = $ligne['lib_vg'];
            $date = $ligne['date_vg'];
            $heure = $ligne['heure_vg'];
            $addresse = $ligne['adr_vg'].' '.$ligne['cp_vg'].' '.$ligne['ville_vg'];
            $nbrRestant = $ligne['nbEmplRestant_vg'];
    
            ?>
            <section class="boxSite">
            <h3>Prochain événement du CIL de la Gravière:</h3>
            <h3><?php echo $label ?></h3>
            <p>Quand? le <?php echo $date ?>, <?php echo $heure ?></p>
            <p>Où? <?php echo $addresse ?></p>
            <p>Exposants ou Visiteurs, nous vous attendons nombreux !</p>
            <p>Réservé exclusivement aux particuliers.</p>
            <!-- <img src="../images/imgVG.jpg" alt="Image de Vide-grenier" id="imgVG"> -->
            <?php
    
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