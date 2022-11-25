<?php
require_once("header.php");

$articles = getArticles();


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
                            <img src="<?php echo $article['image']; ?>" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="photo arbre à chat <?php echo $article['nom']; ?>">
                        </div>
                        <div class="col-md-7 my-auto">
                            <div class="card-body" style="min-width: 180px;">
                                <h5 class="card-title fw-bold text-uppercase"><?php echo $article['nom']; ?></h5>
                                <p class="card-text"><?php echo $article['description']; ?></p>
                                <p class="card-text"><?php echo $article['prix']; ?> €</p>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-secondary m-2" data-bs-toggle="modal" data-bs-target="#detailArticle<?php echo $article['id']; ?>" style="background-color: white; border-color: darksalmon; color: darksalmon;">Détails</button>
                                <!-- Modal -->
                                <div class="modal fade" id="detailArticle<?php echo $article['id']; ?>" tabindex="-1" aria-labelledby="detailArticleTitre" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card text-center" style="box-shadow: 0 0 15px grey; max-height: 90vh;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img src="<?php echo $article['image']; ?>" class="img-fluid rounded-start m-3" style="min-height: 300px; max-height: 50vh; min-width: 200px;" alt="photo arbre à chat <?php echo $article['nom']; ?>">
                                                    </div>
                                                    <div class="col-md my-auto">
                                                        <div class="card-body m-3">
                                                            <h5 class="card-title fw-bold text-uppercase"><?php echo $article['nom']; ?></h5>
                                                            <p class="card-text"><?php echo $article['description']; ?></p>
                                                            <p class="card-text"><?php echo $article['description_detaillee']; ?></p>
                                                            <p class="card-text"><?php echo $article['prix']; ?> €</p>
                                                            <!-- Ajout au panier -->
                                                            <form action="panier.php" method="post">
                                                                <input type="hidden" name="chosenArticle" value="<?php echo $article['id']; ?>">
                                                                <button type="submit" class="btn btn-secondary border-0 m-1" style="background-color: darksalmon;"><i class="fa-solid fa-cart-plus text-white"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="panier.php" method="post">
                                    <input type="hidden" name="chosenArticle" value="<?php echo $article['id']; ?>">
                                    <button type="submit" class="btn btn-secondary border-0 m-1" style="background-color: darksalmon;"><i class="fa-solid fa-cart-plus text-white"></i></button>
                                </form>
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