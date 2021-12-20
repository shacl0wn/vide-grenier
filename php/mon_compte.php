<?php
session_start();

if (isset($_SESSION["id_util"])) {

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mon Compte | CIL de la Gravière</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/monstyle.css">
    </head>

    <body>
        <?php
        include 'inc_header.php';
        // echo $_SESSION['admin'];
        ?>

        <main id="monCompte">
            <?php

            // Test Admin
            if ($_SESSION['admin'] == 1) {
            ?>
                <section class="boxSite">

                    <h2>Gestion Administrateur:</h2>
                    <div id="lienAdmin"><a href="panneau_admin.php" class="bouton">Gestion</a></div>

                </section>

            <?php } ?>

            <section id="récap" class="boxSite">
                <h3>Réservation:</h3>


                <?php


                try {
                    include 'inc_bdd.php';

                    // Recherche des valeurs du compte 
                    $select_utilisateur = 'SELECT * FROM utilisateur WHERE id_util = :id_util';
                    $resultat = $base->prepare($select_utilisateur);
                    $resultat->bindParam(':id_util', $_SESSION["id_util"]);
                    $resultat->execute();

                    while ($ligne = $resultat->fetch()) {

                        $mail = $ligne['mail_util'];

                        if ($ligne['nom_util'] != "") {

                            $nom = $ligne['nom_util'];
                        } else {

                            $nom = "";
                        }

                        if ($ligne['prenom_util'] != "") {

                            $prenom = $ligne['prenom_util'];
                        } else {

                            $prenom = "";
                        }

                        if ($ligne['tel_util'] != "") {

                            $telephone = $ligne['tel_util'];
                        } else {

                            $telephone = "";
                        }

                        if ($ligne['desc_util'] != "") {

                            $description = $ligne['desc_util'];
                        } else {

                            $description = "";
                        }
                    }
                    
                } catch (Exception $e) {

                    die('Erreur : ' . $e->getMessage());
                } finally {

                    $base = null; //fermeture de la connexion
                }

                ?>



            </section>

            <!-- On créer le form avec les valeurs par défaut du compte -->
            <section id="update" class="boxSite">
                <h3>Modifier Profile</h3>
                <form method="post" action="update_inscription.php" id="updateDB">
                    <div class="form-group">
                        <label for="mail">*Mail: </label>
                        <input type="text" class="form-control" name="mail" id="mail" value="<?php echo $mail ?>" placeholder="exemple@mail.com">
                    </div>
                    <div class="form-group">
                        <label for="old_password">Ancien Mot de passe: </label>
                        <input type="password" class="form-control" name="old_password" id="old_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nouveau Mot de passe: </label>
                        <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
                    <div class="form-group">
                        <label for="repeat_password">Répeter Nouveau Mot de passe: </label>
                        <input type="password" class="form-control" name="repeat_password" id="repeat_password">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom: </label>
                        <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $nom ?>" placeholder="Dupont">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom: </label>
                        <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $prenom ?>" placeholder="Jean">
                    </div>
                    <div class="form-group">
                        <label for="tel">Tel.: </label>
                        <input type="text" class="form-control" name="tel" id="tel" value="<?php echo $telephone ?>" placeholder="0XXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label for="description">Une déscription à partager? : </label>
                        <textarea name="description" id="description" cols="31" rows="5" placeholder="280 caractéres maximum..."><?php echo $description ?></textarea>
                    </div>
                    <div class="form-group">
                        <p>(*)Champs obligatoires pour modifier le profil</p>
                    </div>
                    <input class="bouton" type="submit" value="Valider" id="subInscription">

                    <div id="erreurUpdateInscription" class="red">
                        <?php
                        if (isset($_GET["erreur_update_inscription"])) {

                            echo $_GET["erreur_update_inscription"];
                        }
                        ?>
                    </div>
                </form>

            </section>



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