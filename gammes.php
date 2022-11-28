<?php
require_once("header.php");

?>

<section id="section-gammes" class="container text-center mx-auto">

    <?php
    foreach ($gammes as $gamme) {
        $articles = getArticlesFromGammes($gamme['id']);
    ?>
        <div class="row mx-auto mb-5">
            <div class="row mx-auto">
                    <h2 class="text-center fw-bold text-white text-uppercase"><?php echo $gamme['nom'] ?></h2>
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