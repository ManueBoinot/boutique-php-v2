<?php
require_once("header.php");

if (isset($_POST['email'])) {
    connection();
}
?>

<section class="container" id="section-profil">
    <div class="row text-center mx-auto justify-content-center gap-5" style="background-color: rgba(255,255,255,0.8)">

        <!-- TITRE ESPACE PERSO -->
        <div class="row">
            <h3 class="p-4 fst-italic text-secondary">Bienvenue dans votre espace personnel <strong><?php echo $_SESSION['prenom'] ?></strong> !</h3>
        </div>

        <!-- CONTENU ESPACE PERSO -->
        <div class="row">
            <div class="col">
                <a href="infos.php" class="text-decoration-none text-dark d-flex flex-column">
                    <i class="fa-solid fa-user p-3" style="color: #AB6A39; font-size: 5rem;"></i>
                    <label class="fs-3">
                        <h4>Informations personnelles</h4>
                        <h5 class="text-secondary fst-italic">(consulter/modifier)</h5>
                    </label>
                </a>
            </div>
            <div class="col">
                <a href="commandes.php" class="text-decoration-none text-dark d-flex flex-column">
                    <i class="fa-solid fa-basket-shopping p-3" style="color: #AB6A39; font-size: 5rem;"></i>
                    <label class="fs-3">
                        <h4>Mes commandes</h4>
                        <h5 class="text-secondary fst-italic">(consulter)</h5>
                    </label>
                </a>
            </div>
        </div>

        <!-- BOUTON DECONNEXION ESPACE PERSO -->
        <div class="row mx-auto">
            <form action="index.php" method="post">
                <button class="btn btn-lg btn-outline-danger m-4" type="submit" name="deconnexion">Déconnexion</button>
            </form>
        </div>
    </div>
</section>

<?php
include("footer.php");
?>