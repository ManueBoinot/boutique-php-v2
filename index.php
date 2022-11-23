<?php
require_once("header.php");
?>

<section id="section-index" class="d-flex flex-wrap justify-content-around">
<?php
// Import de la BDD complète --------------------------------------
$afficherArticles = 'SELECT * FROM articles';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
$articles = $listeArticles->fetchAll();

// Insertion des cards ARTICLES --------------------------------------
foreach ($articles as $article) {
?>

    <div class="card mb-3 text-center" style="max-width: 540px; min-width: fit-content;">
        <div class="row g-0">
            <div class="col-md-4" style="width: 200px; height: 350px;">
                <img src="<?php echo $article['image']; ?>" class="img-fluid" style="object-fit: cover;" alt="photo arbre à chat <?php echo $article['nom']; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $article['nom']; ?></h5>
                    <p class="card-text"><?php echo $article['description']; ?></p>
                    <button type="button" class="btn btn-secondary"><a class="text-white text-decoration-none" href="produits.php">Voir la boutique</a></button>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>
</section>

<?php
include("footer.php");
?>