<?php
require_once("header.php");

// Import de la BDD complète --------------------------------------
$afficherArticles = 'SELECT * FROM articles';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
$articles = $listeArticles->fetchAll();

?>

<section id="section-produits" class="container text-center">

    <div class="row">
        <?php
        // Afficher un article en détail --------------------------------------
        foreach ($articles as $article) {
        ?>
            <div class="col-md-3 d-flex justify-content-center my-3">
                <div class="card text-center" style="max-width: 540px; box-shadow: 0 0 15px grey;">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="<?php echo $article['image']; ?>" class="img-fluid rounded-start" style="height: 100%;" alt="photo arbre à chat <?php echo $article['nom']; ?>">
                        </div>
                        <div class="col-md-7 my-auto">
                            <div class="card-body" style="min-width: 180px;">
                                <h5 class="card-title fw-bold text-uppercase"><?php echo $article['nom']; ?></h5>
                                <p class="card-text"><?php echo $article['description']; ?></p>
                                <p class="card-text"><?php echo $article['prix']; ?> €</p>
                                <!-- Bouton détails avec MODAL -->
                                <form action="" method="get">
                                    <input type="hidden" name="articleDetail" value="<?php $article['id']; ?>">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-secondary m-2" data-bs-toggle="modal" data-bs-target="#detailArticle" style="background-color: white; border-color: darksalmon; color: darksalmon;">Détails</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="detailArticle" tabindex="-1" aria-labelledby="detailArticleTitre" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detailArticleTitre">...</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ...
                                                </div>
                                                <div class="modal-footer">
                                                    ...
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <button type="button" class="btn btn-secondary border-0 m-1" style="background-color: darksalmon;"><a class="text-white text-decoration-none" href="produits.php"><i class="fa-solid fa-cart-plus text-white"></i></a></button>
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