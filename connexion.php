<?php
require_once("header.php");

if (isset($_POST['nom']))
{
    inscription();
}
?>

<section class="section-connexion container mx-auto p-3">
    <div class="row p-5" style="background-color: rgba(255,255,255,0.7);">
        <div class="row">
            <h1 class="text-center fw-bold p-3">ESPACE PERSONNEL</h1>
        </div>
        <!-- FORMULAIRE DE CONNEXION -->
        <div class="row">
            <form action="profil.php" method="post" class="col-10 offset-1 border p-5 bg-light">
            <h2 class="text-center p-3">Se connecter</h2>
                <div class="row my-3 px-5">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" required>
                </div>
                <div class="row my-3 px-5">
                    <label for="inputMdp" class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" id="inputMdp" required>
                </div>
                <div class="row my-3 px-5">
                    <button type="submit" class="col-4 offset-4 btn btn-outline-primary fw-bold text-white border-0" style="background-color: darksalmon;">Se connecter</button>
                </div>
            </form>
        </div>
        <!-- INVITATION INSCRIPTION -->
        <div class="row">
            <h2 class="text-center p-3 mt-5 fst-italic">Pas encore inscrit(e) ?</h2>
            <button type="submit" class="col-4 offset-4 btn btn-light btn-lg  fw-bold" style="background-color: darksalmon;"><a href="inscription.php" class="text-decoration-none" style="color: white;">Créer un compte</a></button>
        </div>
    </div>
</section>

<?php
include("footer.php");
?>