<?php
require_once("header.php");

$articles = getArticles();

// Vider le panier  -------------------------
if (isset($_POST['resetCart'])) {
    saveOrder();
    resetCart();
}

// Reset panier après commande -------------------------
if (isset($_POST['newCart'])) {
    saveOrder();
    resetCart();
}

// Reset $_SESSION  -------------------------
if (isset($_POST['deconnexion'])) {
    $_SESSION = [];
}
?>

<section id="section-index" class="container text-center">

    <div class="row">

        <!-- TITRE ACCUEIL -->
        <h1 class="fw-bold text-white m-5">Bienvenue sur notre site !</h1>
        <?php

        // Insertion des cards ARTICLES --------------------------------------
        foreach ($articles as $article) {
        ?>
            <div class="col-md-6 d-flex justify-content-center my-3">
                <div class="card text-center" style="max-width: 540px; box-shadow: 0 0 15px grey;">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="<?php echo $article['image']; ?>" class="img-fluid rounded-start" style="object-fit: cover; min-height: 300px; min-width: 200px;" alt="photo arbre à chat <?php echo $article['nom']; ?>">
                        </div>
                        <div class="col-md-7 my-auto">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-uppercase"><?php echo $article['nom']; ?></h5>
                                <p class="card-text"><?php echo $article['description']; ?></p>
                                <button type="button" class="btn btn-secondary border-0" style="background-color: darksalmon;"><a class="text-white text-decoration-none" href="gammes.php">+ d'info</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</section>

<?php
include("footer.php");
?>