<?php
require_once("header.php");

$gammes = getGammes();
?>

<section id="section-gammes">

    <?php

    foreach ($gammes as $gamme) {
    ?>

        <div>

        <h2><?php echo $gamme['nom'] ?></h2>


        </div>


    <?php
    }
    ?>









</section>

<?php
include("footer.php");
?>