<?php
require_once("header.php");

// Ajouter un produit au panier -------------------------
if (isset($_POST['chosenArticle'])) {
    $idChosen = $_POST['chosenArticle'];
    $articleChosen = getArticleFromId($idChosen);
    addArticleToCart($articleChosen);
}

// Modifier la quantité d'un produit dans le panier -------------------------
if (isset($_POST['changeIdQty'])) {
    changeQty();
}

// Supprimer un produit du panier -------------------------
if (isset($_POST['removeItem'])) {
    removeItem();
}

// Vider le panier  -------------------------
if (isset($_POST['resetCart'])) {
    resetCart();
}

if (isset($_POST['nom'])) {
    modifIdentifiants();
}

if (isset($_POST['adresse'])) {
    modifAdresse();
}

$totalCommande = totalCommande();

?>

<section class="container fs-3 mx-auto p-5" id="section-panier">
    <div id="contenu-panier">
        <table class="table table-striped bg-light bg-gradient text-start">
            <thead>
                <tr class="bg-dark bg-gradient text-white">
                    <th scope="col">Réf.</th>
                    <th scope="col">Produit</th>
                    <th scope="col" class="text-end">Prix unitaire (TTC)</th>
                    <th scope="col" class="text-end">Quantité</th>
                    <th scope="col"></th>
                    <th scope="col" class="text-end">Prix total (TTC)</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
                <?php echo afficherPanier() ?>
            </tbody>

            <tfoot class="table-group-divider text-end">
                <tr>
                    <th class="text-center text-uppercase bg-dark bg-gradient text-white" colspan="6">Récapitulatif du panier</th>
                </tr>
                <tr>
                    <td colspan="5">Montant total des produits</td>
                    <td colspan="1"><?php echo totalPanier() ?> €</td>
                </tr>
                <tr>
                    <td colspan="5">Frais de port (10 € par article)</td>
                    <td colspan="1"><?php echo totalPort() ?> €</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="5">Montant à régler (TTC)</td>
                    <td colspan="1"><?php echo totalCommande() ?> €</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between text-center" id="footer-panier">
        <div id="btn-vider-panier">
            <form action="panier.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir vider le panier ?');">
                <input type="hidden" name="resetCart">
                <button type="submit" class="btn btn-danger btn-lg">Vider le panier</button>
            </form>
        </div>

        <!-- MODAL VALIDATION PANIER -->
        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title  " id="exampleModalToggleLabel">Votre panier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body px-5 d-grid gap-4">
                        <!-- Récap PANIER -->
                        <div id="recap-panier" class="bt-3 border">
                            <h2 class="fw-bold py-3 text-info">Récapitulatif de votre commande</h2>
                            <p>Total articles : <span class="fw-bold"><?php echo totalPanier() ?></span> €</p>
                            <p>Frais de port : <span class="fw-bold"><?php echo totalPort() ?></span> €</p>
                            <p>TOTAL À PAYER : <span class="fw-bold"><?php echo $totalCommande ?></span> €</p>
                        </div>

                        <div class="row text-start d-grid gap-3" style="font-size: 1rem;">

                            <!-- Information client -->
                            <div class="row mx-auto px-5" style="font-size: 1.3rem;">
                                <div>
                                    <h5 class="fw-bold mb-5 text-center text-info">VOS INFORMATIONS ENREGISTRÉES</h5>
                                </div>
                                <div class="d-flex gap-5 ms-5">
                                    <div>
                                        <label class="fw-bold">Nom</label>
                                        <p class="bg-white"><?php echo $_SESSION['nom'] ?></p>
                                    </div>
                                    <div>
                                        <label class="fw-bold">Prénom</label>
                                        <p class="bg-white"><?php echo $_SESSION['prenom'] ?></p>
                                    </div>
                                </div>
                                <div class="d-flex gap-5 ms-5">
                                    <div>
                                        <label class="fw-bold">N° et nom de la voie</label>
                                        <p class="bg-white"><?php echo $_SESSION['adresse'] ?></p>
                                    </div>
                                    <div>
                                        <label class="fw-bold">Code postal</label>
                                        <p class="bg-white"><?php echo $_SESSION['cp'] ?></p>
                                    </div>
                                    <div>
                                        <label class="fw-bold">Commune</label>
                                        <p class="bg-white"><?php echo $_SESSION['ville'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Modifier DESTINATAIRE -->
                            <div class="row mx-auto px-5">
                                <form action="panier.php" method="post" class="p-2 text-start bg-warning bg-opacity-10 border">
                                    <h5 class="mb-1 text-center fw-bold text-warning">CHANGER DE DESTINATAIRE</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Modifier votre nom</label>
                                        <input name="nom" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Modifier votre prénom</label>
                                        <input name="prenom" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Modifier votre adresse email</label>
                                        <input name="email" type="email" class="form-control" aria-describedby="emailHelp">
                                        <div id="emailHelp" class="form-text">Tapez ici votre nouvelle adresse-email</div>
                                    </div>
                                    <div class="mb-3 text-danger">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <input name="mdp" type="password" class="form-control" aria-describedby="pwHelp" required>
                                        <div id="pwHelp" class="form-text text-danger">Entrez votre mot de passe pour valider les modifications</div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="col-6 btn btn-danger text-white mx-auto">Valider ces modifications</button>
                                    </div>
                                </form>
                            </div>


                            <!-- Modifier ADRESSE LIVRAISON -->
                            <div class="row mx-auto px-5">
                                <form action="panier.php" method="post" class="text-start p-2 bg-warning bg-opacity-10 border">
                                    <h5 class="mb-1 text-center fw-bold text-warning">MODIFIER VOTRE ADRESSE</h5>
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
                                    <div class="mb-3 text-danger">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <input name="mdp" type="password" class="form-control" aria-describedby="pwHelp" required>
                                        <div id="pwHelp" class="form-text text-danger">Entrez votre mot de passe pour valider les modifications</div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="col-6 btn btn-danger text-white mx-auto">Valider ces modifications</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton VALIDER COMMANDE -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">CONFIRMER VOTRE COMMANDE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal VALIDATION COMMANDE -->
        <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title  " id="exampleModalToggleLabel2">Merci pour votre commande !</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 d-grid gap-5">
                        <h2 class="fw-bold py-3" style="color: green;">Votre commande a été validée</h2>
                        <p>Montant total : <span class="fw-bold"><?php echo $totalCommande ?></span> €</p>
                        <p>Elle sera expédiée le <span class="fw-bold"><?php echo date('d-m-Y', strtotime($date . ' + 2 days')) ?></span></p>
                        <p>Livraison estimée le <span class="fw-bold"><?php echo date('d-m-Y', strtotime($date . ' + 7 days')) ?></span></p>
                        <p>Merci pour votre confiance et à bientôt !</p>
                    </div>
                    <div class="modal-footer">
                        <form action="index.php" method="post">
                            <input type="hidden" name="newCart">
                            <button type="submit" class="btn btn-secondary">Retour à l'accueil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php if(count($_SESSION['cart']) > 0){ ?>
            <a class="btn btn-lg btn-warning fw-bold border border-dark" data-bs-toggle="modal" href="#exampleModalToggle" role="button">VALIDER LE PANIER</a>
            <?php } ?>

    </div>
</section>

<?php
include("footer.php");
?>