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

$totalCommande = totalCommande();

?>

<section class="container fs-3 mx-auto p-5" id="section-panier">
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

    <div class="d-flex justify-content-between">
        <div>
            <form action="panier.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir vider le panier ?');">
            <input type="hidden" name="resetCart">
                <button type="submit" class="btn btn-secondary btn-lg">Vider le panier</button>
            </form>
        </div>

        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger btn-lg fw-bold fs-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                VALIDER LA COMMANDE
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content text-center d-grid gap-3">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="staticBackdropLabel">Merci pour votre commande !</h1>
                        </div>
                        <div class="modal-body px-5 d-grid gap-5">
                            <h2 class="fw-bold py-3" style="color: green;">Votre commande a été validée</h2>
                            <p>Montant total : <span class="fw-bold"><?php echo $totalCommande ?></span> €</p>
                            <p>Elle sera expédiée le <span class="fw-bold"><?php echo date('d-m-Y', strtotime($date . ' + 2 days')) ?></span></p>
                            <p>Livraison estimée le <span class="fw-bold"><?php echo date('d-m-Y', strtotime($date . ' + 7 days')) ?></span></p>
                            <p>Merci pour votre confiance et à bientôt sur Arbr'à'chadabra !</p>
                        </div>
                        <div class="modal-footer px-5">
                            <form action="index.php" method="post">
                                <input type="hidden" name="resetCart">
                                <button type="submit" class="btn btn-secondary">Retour à l'accueil</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php
include("footer.php");
?>