<?php
require_once("header.php");


if (isset($_POST['nom'])) {
    modifIdentifiants();
}

if (isset($_POST['adresse'])) {
    modifAdresse();
}

if (isset($_POST['newPwConfirm'])) {
    modifMdp();
}

?>

<section class="container mx-auto p-5" style="background-color: rgba(255,255,255,0.8)">
    <div class="row gap-5 p-5 bg-light">
        <h1 class="text-center">Informations personnelles</h1>

        <!-- INFORMATIONS UTILISATEURS -->
        <div class="col bg-light p-3 border">
            <!-- Bloc titre -->
            <div class="row mb-3">
                <h2 class="mb-5 text-center">VOS INFORMATIONS</h2>
            </div>
            <!-- Bloc nom-prénom -->
            <div class="row mb-3">
                <div class="col">
                    <label class="fw-bold">Nom</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['nom'] ?></p>
                </div>
                <div class="col">
                    <label class="fw-bold">Prénom</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['prenom'] ?></p>
                </div>
            </div>
            <!-- Bloc adresse -->
            <div class="row mb-3">
                <div class="col-12">
                    <label class="fw-bold">N° et nom de la voie</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['adresse'] ?></p>
                </div>
                <div class="col">
                    <label class="fw-bold">Code postal</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['cp'] ?></p>
                </div>
                <div class="col">
                    <label class="fw-bold">Commune</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['ville'] ?></p>
                </div>
            </div>
            <!-- Bloc email -->
            <div class="row mb-3">
                <div class="col">
                    <label class="fw-bold">Adresse email</label>
                    <p class="fs-4 bg-white"><?php echo $_SESSION['email'] ?></p>
                </div>
            </div>
            <!-- Bloc modif adresse -->
            <form action="infos.php" method="post" class="text-start bg-white m-2 p-3 border border-info">
                <h5 class="fw-bold text-center text-info mb-3">Modifier votre adresse</h5>
                <div class="mb-3">
                    <label class="form-label">N° et nom de la voie</label>
                    <input name="adresse" type="text" class="form-control" aria-describedby="adresseHelp">
                    <div id="adresseHelp" class="form-text">Tapez ici votre nouvelle adresse</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Code postal</label>
                    <input name="cp" type="text" class="form-control" aria-describedby="cpHelp">
                    <div id="cpHelp" class="form-text">Tapez ici votre nouveau code postal</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ville</label>
                    <input name="ville" type="text" class="form-control" aria-describedby="villeHelp">
                    <div id="villeHelp" class="form-text">Tapez ici votre nouvelle commune</div>
                </div>
                <div class="mb-3 p-2 bg-light border border-info text-info">
                    <label class="form-label">Mot de passe actuel</label>
                    <input name="mdp" type="password" class="form-control" aria-describedby="pwHelp" required>
                    <div id="pwHelp" class="form-text text-info">Entrez votre mot de passe pour valider les modifications</div>
                </div>
                <div class="row">
                    <button type="submit" class="col-6 btn btn-info text-white mx-auto">Valider ces modifications</button>
                </div>
            </form>
        </div>

        <!-- INFORMATIONS À MODIFIER -->
        <div class="col bg-light p-3 border border-danger">
            <!-- Bloc modif identifiants -->
            <form action="infos.php" method="post" class="text-start bg-white m-2 p-3 border">
                <h5 class="fw-bold text-danger text-center mb-3">Modifier vos identifiants</h5>
                <div class="mb-3">
                    <label class="form-label">Modifier votre nom</label>
                    <input name="nom" type="text" class="form-control" aria-describedby="nomHelp">
                    <div id="nomHelp" class="form-text">Tapez ici votre nouveau nom</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Modifier votre prénom</label>
                    <input name="prenom" type="text" class="form-control" aria-describedby="prenomHelp">
                    <div id="prenomHelp" class="form-text">Tapez ici votre nouveau prénom</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Modifier votre adresse email</label>
                    <input name="email" type="email" class="form-control" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Tapez ici votre nouvelle adresse-email</div>
                </div>
                <div class="mb-3 p-2 bg-light border border-danger text-danger">
                    <label class="form-label">Mot de passe actuel</label>
                    <input name="mdp" type="password" class="form-control" aria-describedby="pwHelp" required>
                    <div id="pwHelp" class="form-text text-danger">Entrez votre mot de passe pour valider les modifications</div>
                </div>
                <div class="row">
                    <button type="submit" class="col-6 btn btn-danger mx-auto">Valider ces modifications</button>
                </div>
            </form>


            <!-- Bloc modif MOT DE PASSE -->
            <form action="infos.php" method="post" class="text-start bg-white m-2 p-3 border">
                <h5 class="fw-bold text-center text-danger mb-3">Modifier votre mot de passe</h5>
                <div class="mb-3">
                    <label class="form-label">Mot de passe actuel</label>
                    <input name="oldPw" type="password" class="form-control" aria-describedby="oldPw" required>
                    <div id="oldPw" class="form-text">Tapez votre mot de passe actuel</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input name="newPw" type="password" class="form-control" aria-describedby="newPw" required>
                    <div id="newPw" class="form-text">Tapez votre nouveau mot de passe</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmez votre nouveau mot de passe</label>
                    <input name="newPwConfirm" type="password" class="form-control" aria-describedby="newPwConfirm" required>
                    <div id="newPwConfirm" class="form-text">Tapez une seconde fois votre nouveau mot de passe</div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-danger mx-auto">Valider ces modifications</button>
                </div>
            </form>

        </div>

    </div>


</section>

<?php
include("footer.php");
?>