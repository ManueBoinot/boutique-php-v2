<?php
require_once("header.php");

// Import de la BDD complète --------------------------------------
$afficherArticles = 'SELECT * FROM articles';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
$articles = $listeArticles->fetchAll();
?>

<section id="section-index" class="container text-center">
    <div class="row">
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
                                <button type="button" class="btn btn-secondary border-0" style="background-color: darksalmon;"><a class="text-white text-decoration-none" href="produits.php">+ d'info</a></button>
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