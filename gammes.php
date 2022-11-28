<?php
require_once("header.php");
$gammes = getGammes();
?>

<section id="section-gammes" class="container text-center mx-auto">

<h1 class="fw-bold text-white m-5">NOS PRODUITS</h1>

    <?php
    foreach ($gammes as $gamme) {
        $articles = getArticlesFromGammes($gamme['id']);
    ?>
        <div class="row mx-auto mb-5" style="border: 1px solid white; background-color: rgba(255,255,255,0.6)">
            <div class="row mx-auto">
                    <h2 class="text-center fw-bold text-uppercase m-2" style="color: #AB6A39;">Gamme " <?php echo $gamme['nom'] ?> "</h2>
            </div>
            <div class="row mx-auto">
                    <?php showArticles($articles) ?>
            </div>
        </div>
    <?php
    }
    ?>

</section>

<?php
include("footer.php");
?>