<?php

// FONCTIONS PRESENTES SUR TOUTES LES PAGES --------------------------------------

// Connexion à la BDD --------------------------------------
function getConnection()
{
try {
    $db = new PDO(
        'mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8',
        'manue',
        'Re04glisse0833!',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC)
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
return $db;
}

// Création de la session --------------------------------------
session_start();

// Définition du fuseau horaire --------------------------------------
date_default_timezone_set('Europe/Paris');
$date = 'now';

// Création du panier s'il n'existe pas déjà --------------------------------------
function createCart()
{
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
}
createCart();

// Import de la BDD complète --------------------------------------
function getArticles()
{
$db = getConnection();
$afficherArticles = 'SELECT * FROM articles';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
return $listeArticles->fetchAll();
}

// Import des GAMMES --------------------------------------
function getGammes()
{
$db = getConnection();
$afficherArticles = 'SELECT * FROM gammes';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
return $listeArticles->fetchAll();
}

$gammes = getGammes();

// Import des articles selon leur GAMME --------------------------------------
function getArticlesByGamme($idGammes)
{
$db = getConnection();
$afficherArticles = 'SELECT id FROM articles';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
return $listeArticles->fetchAll();
}

// Sélectionner les informations d'un produit -------------------------
function getArticleFromId($idArticle)
{
    foreach (getArticles() as $article) {
        if ($article['id'] == $idArticle) {
            return $article;
        }
    }
}

// Ajouter un produit au panier -------------------------
function addArticleToCart($article)
{
    foreach ($_SESSION['cart'] as $cartArticle) {
        if ($cartArticle['id'] == $article['id']) {
            echo "<script>alert('Article déjà présent dans le panier')</script>";
            return;
        }
    }
    $article['quantite'] = 1;
    array_push($_SESSION['cart'], $article);
}

// Affichage du contenu du panier -------------------------
function afficherPanier()
{
    foreach ($_SESSION['cart'] as $article) {
        echo "<tr>
                    <td>" . $article['id'] . "</td>
                    <td>" . $article['nom'] . "</td>
                    <td class=\"text-end\">" .  $article['prix'] . " €</td>
                    <td class=\"text-end\">
                        <form action=\"panier.php\" method=\"post\">
                            <input type=\"hidden\" name=\"changeIdQty\" value=\"" . $article['id'] . "\">
                            <input type=\"number\" min=\"1\" max=\"5\" name=\"nouvelleQuantite\" value=\"" . $article['quantite'] . "\">
                            <input class=\"btn btn-dark p-3 m-2 fw-bold\" type=\"submit\" value=\"Valider\">
                        </form>
                    </td>
                    <td class=\"text-start\">
                        <form action=\"panier.php\" method=\"post\" onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')\">
                            <input type=\"hidden\" name=\"removeItem\" value=\"" . $article['id'] . "\">
                            <button class=\"btn btn-danger p-3 m-2 fw-bold\" type=\"submit\">X</button>
                        </form>
                    </td>
                    <td class=\"text-end\">" .  $article['quantite'] * $article['prix'] . " €</td>
                </tr>";
    }
}

// Modifier la quantité d'un produit dans le panier -------------------------
function changeQty()
{
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $_POST['changeIdQty']) {
            $_SESSION['cart'][$i]['quantite'] = $_POST['nouvelleQuantite'];
        }
    }
}

// Supprimer un produit du panier -------------------------
function removeItem()
{
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $_POST['removeItem']) {
            array_splice($_SESSION['cart'], $i, 1);
        }
    }
}

// Calculer le total des produits du panier -------------------------
function totalPanier()
{
    $total = 0;

    foreach ($_SESSION['cart'] as $article) {
        $total += $article['quantite'] * $article['prix'];
    }
    return $total;
}


// Calculer le total des frais de port -------------------------
function totalPort()
{
    $total = 0;

    foreach ($_SESSION['cart'] as $article) {
        $total += $article['quantite'] * 10;
    }
    return $total;
}


// Calculer le total de la commande (produits + frais de port) -------------------------
function totalCommande()
{
    $total = totalPanier() + totalPort();
    return $total;
}

// Vider le panier -------------------------
function resetCart()
{
    $_SESSION['cart'] = [];
}


?>