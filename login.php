<?php
require_once("header.php");
?>

<body>

    <div class="row">
        <form action="profil.php" method="post" class="col-10 offset-1 border p-5 bg-light">
            <h2 class="text-center p-3">Se connecter</h2>
            <div class="row my-3 px-5">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" name="login" class="form-control" id="inputEmail">
            </div>
            <div class="row my-3 px-5">
                <label for="inputMdp" class="form-label">Mot de passe</label>
                <input type="password" name="mdp" class="form-control" id="inputMdp">
            </div>
            <div class="row my-3 px-5">
                <button type="submit" name="connexion" class="col-4 offset-4 btn btn-outline-primary fw-bold" style="border-color: darksalmon;"><a href="profil.php" class="text-decoration-none" style="color: darksalmon;">Se connecter</a></button>
            </div>
        </form>
    </div>
</body>

<?php
include("footer.php");
?>