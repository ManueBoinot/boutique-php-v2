<?php
require_once("header.php");
?>

<section class="container text-center mx-auto p-5" style="background-color: rgba(255,255,255,0.8)">
    <div class="row gap-5">
        <h1>Informations personnelles</h1>

        <!-- INFORMATIONS UTILISATEURS -->
        <div class="col bg-white">
            <h2>Vos informations enregistrées</h2>
            <div class="text-start bg-white m-2 p-3">
                <div class="row mb-3">
                    <div class="col">
                        <label class="fw-bold">Nom</label>
                        <p class="fs-4"><?php echo $_SESSION['nom'] ?></p>
                    </div>
                    <div class="col">
                        <label class="fw-bold">Prénom</label>
                        <p class="fs-4"><?php echo $_SESSION['prenom'] ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="fw-bold">N° et nom de la voie</label>
                        <p class="fs-4"><?php echo $_SESSION['adresse'] ?></p>
                    </div>
                    <div class="col">
                        <label class="fw-bold">Code postal</label>
                        <p class="fs-4"><?php echo $_SESSION['cp'] ?></p>
                    </div>
                    <div class="col">
                        <label class="fw-bold">Commune</label>
                        <p class="fs-4"><?php echo $_SESSION['ville'] ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="fw-bold">Adresse email</label>
                    <p class="fs-4"><?php echo $_SESSION['email'] ?></p>
                </div>
            </div>
        </div>

        <!-- INFORMATIONS À MODIFIER -->
        <div class="col bg-secondary">
            <h2 class="text-center">Informations à modifier</h2>
            <form class="text-start bg-white m-2 p-3">
                <h5 class="text-center">Identifiants de connexion</h5>
                <div class="mb-3">
                    <label for="" class="form-label">Nouvelle adresse email</label>
                    <input type="email" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Mot de passe actuel</label>
                    <input type="password" class="form-control" id="" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="">
                </div>
                <button type="submit" class="btn btn-danger">Valider ces modifications</button>
            </form>

            <form class="text-start bg-white m-2 p-3">
                <h5 class="text-center">Adresse postale</h5>
                <div class="mb-3">
                    <label for="" class="form-label">N° et nom de la voie</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Code postal</label>
                    <input type="text" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Ville</label>
                    <input type="text" class="form-control" id="">
                </div>
                <button type="submit" class="btn btn-danger">Valider ces modifications</button>
            </form>
        </div>

    </div>


</section>

<?php
include("footer.php");
?>