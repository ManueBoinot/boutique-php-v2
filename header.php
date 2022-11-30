<?php
require("functions.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbr'à'chadabra - Création de mobilier pour animaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cfc69e35cf.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Athiti&family=Rubik+Beastly&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>


<header class="container-fluid position-fixed top-0 p-0" style="z-index: 1">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container d-flex flex-column">

            <!-- LOGO EN-TÊTE -->
            <a class="navbar-brand mx-auto px-5 text-center" href="index.php" style="max-width: 100vw;">
                <h1 style="font-family: Rubik beastly, arial, serif; font-size: 3rem; color: #AB6A39;">Arbr'à'chadabra</h1>
                <h2 class="fst-italic" style="font-size: 1rem;">Création de mobilier pour animaux</h2>
            </a>
            <!-- Toggler burger pour responsive -->
            <button class="navbar-toggler text-center mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU COMMUN -->
            <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                <ul class="navbar-nav me-5">
                    <li class="nav-item m-3">
                        <a class="nav-link activems-4" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item m-3">
                        <a class="nav-link" href="gammes.php">Produits</a>
                    </li>
                </ul>

                <!-- MENU SI UTILISATEUR CONNECTÉ -->
                <?php if (isset($_SESSION['id'])) { ?>
                    <ul class="navbar-nav me-5">
                        <li class="nav-item m-3">
                            <a class="nav-link activems-4" aria-current="page" href="profil.php">Mon profil</a>
                        </li>
                        <li class="nav-item m-3">
                            <form action="index.php" method="post">
                                <button class="btn btn-outline-danger" type="submit" name="deconnexion">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-secondary btn-lg ms-5 me-2 border-0" style="background-color: darksalmon;"><a href="panier.php"><i class="fa-solid fa-cart-shopping text-white"></i></a></button>

                <!-- MENU SI UTILISATEUR NON CONNECTÉ -->
                <?php } else { ?>
                    <button type="button" class="btn btn-outline-secondary btn-lg ms-5" style="border-color: darksalmon;"><a href="connexion.php"><i class="fa-solid fa-user" style="color: orange;"></i></a></button>
                    <button type="button" class="btn btn-secondary btn-lg ms-5 me-2 border-0" style="background-color: darksalmon;"><a href="panier.php"><i class="fa-solid fa-cart-shopping text-white"></i></a></button>
                <?php }
                ?>

            <!-- INFO UTILISATEUR CONNECTÉ -->
            </div> <?php if (isset($_SESSION['id'])) {
                        echo '<h3 class="fst-italic text-secondary" style="font-size: 0.9rem;">(Vous êtes connecté(e) en tant que <strong>' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '</strong>)</h3>';
                    }
                    ?>

        </div>
    </nav>
</header>

<body class="w-100" style="margin: 250px 0 100px 0; background-image: url(images/bg_chat2.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; font-family: Athiti, arial, serif;">