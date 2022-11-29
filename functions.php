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
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
return $db;
}
$db = getConnection();

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
$articles = getArticles();



// ------------------------------------------------------------------------------
// FONCTIONS PAGE INSCRIPTION --------------------------------------

function verifyEmail()
{
    $db = getConnection();
    $query = $db->prepare('SELECT * FROM clients WHERE email = ?');
    $query->execute([$_POST['email']]);
    return $query->fetch();
}

function checkInputsLength()
{
    $inputsLengthOk = true;

    if (strlen($_POST['nom']) > 25 || strlen($_POST['nom']) < 3) {
        $inputsLengthOk = false;
    }

    if (strlen($_POST['prenom']) > 25 || strlen($_POST['prenom']) < 3) {
        $inputsLengthOk = false;
    }

    if (strlen($_POST['email']) > 25 || strlen($_POST['email']) < 5) {
        $inputsLengthOk = false;
    }

    if (strlen($_POST['adresse']) > 40 || strlen($_POST['adresse']) < 5) {
        $inputsLengthOk = false;
    }

    if (strlen($_POST['cp']) !== 5) {
        $inputsLengthOk = false;
    }

    if (strlen($_POST['ville']) > 25 || strlen($_POST['ville']) < 3) {
        $inputsLengthOk = false;
    }

    return $inputsLengthOk;
}

function checkEmptyFields()
{
    foreach ($_POST as $field) {
        if (empty($field)) {
            return true;
        }
    }
    return false;
}

function checkPassword($mdp)    { 
    // minimum 8 caractères et maximum 15, minimum 1 lettre, 1 chiffre et 1 caractère spécial
        $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
        return preg_match($regex, $mdp);
    }
    

function inscription()
{

    $db = getConnection(); 

    if (checkEmptyFields()) { 
        echo "<script>alert('Compléter les champs vides')</script>";
    } else {

        if (checkInputsLength() == false) { 
            echo "<script>alert('Longueur incorrecte d'un ou plusieurs champs')</script>";
        } else {

            if (verifyEmail($_POST['email'])) { 
                echo "<script>alert('Adresse email déjà utilisée')</script>";
            } 
        }
}
        
        $sqlQuery = "INSERT INTO clients(nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)";
        $insertNewUser = $db->prepare($sqlQuery);
        $insertNewUser->execute([
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
        ]);

        $id = $db->lastInsertId();

        $sqlQuery2 = "INSERT INTO adresses( id_client, adresse, cp, ville) VALUES (:id_client, :adresse, :cp, :ville)";
        $insertNewAdresse = $db->prepare($sqlQuery2);
        $insertNewAdresse->execute([
            'id_client'=> $id,
            'adresse' => $_POST['adresse'],
            'cp' => $_POST['cp'],
            'ville' => $_POST['ville'],
        ]);

        echo "<script>alert('Votre inscription s'est déroulée avec succès !'</script>";
    }


// ------------------------------------------------------------------------------
// FONCTIONS PAGE PRODUITS --------------------------------------

// Import des GAMMES --------------------------------------
function getGammes()
{
$db = getConnection();
$afficherArticles = 'SELECT * FROM gammes';
$listeArticles = $db->prepare($afficherArticles);
$listeArticles->execute();
return $listeArticles->fetchAll();
}

// Sélection des ARTICLES par leur id de GAMME --------------------------------------
function getArticlesFromGammes($idGamme)
{
    $db = getConnection();
    $query = $db->prepare('SELECT * FROM articles WHERE id_gamme = ?');
    $query->execute([$idGamme]);
    return $query->fetchAll();
}

// Affichage des articles selon leur GAMME --------------------------------------
function showArticles($articles)
{
    foreach ($articles as $article) {
        echo "<div class=\"col-md-6 d-flex justify-content-center my-3\">
        <div class=\"card text-center\" style=\"max-width: 540px; box-shadow: 0 0 15px grey;\">
            <div class=\"row g-0\">
                <div class=\"col-md-5\">
                    <img src=\"" . $article['image'] . "\" class=\"img-fluid rounded-start\" style=\"height: 100%; object-fit: cover;\" alt=\"photo arbre à chat " . $article['nom'] . " ?>\">
                </div>
                <div class=\"col-md-7 my-auto\">
                    <div class=\"card-body\" style=\"min-width: 180px;\">
                        <h5 class=\"card-title fw-bold text-uppercase\">".  $article['nom'] . "</h5>
                        <p class=\"card-text\"" . $article['description'] . " ?></p>
                        <p class=\"card-text\">" . $article['prix'] . " €</p>
                        <!-- Button trigger modal -->
                        <button type=\"button\" class=\"btn btn-outline-secondary m-2\" data-bs-toggle=\"modal\" data-bs-target=\"#detailArticle".  $article['id'] . "\" style=\"background-color: white; border-color: darksalmon; color: darksalmon;\">Détails</button>
                        <!-- Modal -->
                        <div class=\"modal fade\" id=\"detailArticle" .  $article['id'] . "\" tabindex=\"-1\" aria-labelledby=\"detailArticleTitre\" aria-hidden=\"true\">
                            <div class=\"modal-dialog\">
                                <div class=\"modal-content\">
                                    <div class=\"card text-center\" style=\"box-shadow: 0 0 15px grey; max-height: 90vh;\">
                                        <div class=\"row\">
                                            <div class=\"col-md-12\">
                                                <img src=\" " . $article['image'] . " \" class=\"img-fluid rounded-start m-3\" style=\"min-height: 300px; max-height: 50vh; min-width: 200px;\" alt=\"photo arbre à chat " .  $article['nom'] . "\">
                                            </div>
                                            <div class=\"col-md my-auto\">
                                                <div class=\"card-body m-3\">
                                                    <h5 class=\"card-title fw-bold text-uppercase\"> " . $article['nom'] . "</h5>
                                                    <p class=\"card-text\"> " . $article['description'] . "</p>
                                                    <p class=\"card-text\"> " . $article['description_detaillee'] . "</p>
                                                    <p class=\"card-text\"> " . $article['prix'] . " €</p>
                                                    <!-- Ajout au panier -->
                                                    <form action=\"panier.php\" method=\"post\">
                                                        <input type=\"hidden\" name=\"chosenArticle\" value=\" " . $article['id'] . "\">
                                                        <button type=\"submit\" class=\"btn btn-secondary border-0 m-1\" style=\"background-color: darksalmon;\"><i class=\"fa-solid fa-cart-plus text-white\"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action=\"panier.php\" method=\"post\">
                            <input type=\"hidden\" name=\"chosenArticle\" value=\" " . $article['id'] . "\">
                            <button type=\"submit\" class=\"btn btn-secondary border-0 m-1\" style=\"background-color: darksalmon;\"><i class=\"fa-solid fa-cart-plus text-white\"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    }
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


// ------------------------------------------------------------------------------
// FONCTIONS PAGE PANIER --------------------------------------

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
