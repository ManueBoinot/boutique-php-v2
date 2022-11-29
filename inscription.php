<?php
require_once("header.php");
?>

<section class="section-inscription container mx-auto p-3">
    <div class="row p-5" style="background-color: rgba(255,255,255,0.7);">
        <div class="row text-center pb-3">
            <h1 class="fw-bold">CRÉATION D'UN ESPACE PERSONNEL</h1>
            <h2 class="fs-4">Merci de compléter le formulaire ci-dessous :</h2>
        </div>
        <!-- FORMULAIRE D'INSCRIPTION -->
        <div class="row px-5 mx-auto">
            <form action="connexion.php" method="post" class="row bg-light border p-5 gap-2">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword" class="form-label">Mot de passe</label>
                        <input type="password" name="mdp" id="inputPassword" class="form-control" aria-describedby="passwordHelpBlock" required>
                        <div id="passwordHelpBlock" class="form-text">
                            Votre mot de passe doit contenir entre 8 et 15 caractères, contenir au minimum 1 lettre, 1 chiffre et 1 caractère spécial.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPrenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="inputAdresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" id="inputAdresse" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputCP" class="form-label">Code postal</label>
                        <input type="text" name="cp" class="form-control" id="inputCp" required>
                    </div>
                    <div class="col-md-9">
                        <label for="inputVille" class="form-label">Ville</label>
                        <input type="text" name="ville" class="form-control" id="inputVille" required>
                    </div>
                </div>
                <div class="row m-3 w-75 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg border-0 fw-bold" style="background-color: darksalmon;">Créer mon compte</button>
                </div>
            </form>
        </div>


    </div>
</section>

<?php
include("footer.php");
?>