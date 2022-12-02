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
// FONCTIONS UTILISATEURS --------------------------------------

// Vérification existence email dans BDD --------------------------------------

function verifyEmail($email)
{
    $db = getConnection();
    $query = $db->prepare('SELECT * FROM clients WHERE email = ?');
    $query->execute([$email]);
    return $query->fetch();
}

// Vérification de la longueur des champs du formulaire d'inscription ------------
function checkInputsLength()
{
    $inputsLengthOk = true;

    if (isset($_POST['nom'])) {
        if (strlen($_POST['nom']) > 25 || strlen($_POST['nom']) < 3) {
            $inputsLengthOk = false;
        }
    }

    if (isset($_POST['prenom'])) {
        if (strlen($_POST['prenom']) > 25 || strlen($_POST['prenom']) < 3) {
            $inputsLengthOk = false;
        }
    }

    if (isset($_POST['email'])) {
        if (strlen($_POST['email']) > 40 || strlen($_POST['email']) < 5) {
            $inputsLengthOk = false;
        }
    }

    if (isset($_POST['adresse'])) {
        if (strlen($_POST['adresse']) > 40 || strlen($_POST['adresse']) < 5) {
            $inputsLengthOk = false;
        }
    }

    if (isset($_POST['cp'])) {
        if (strlen($_POST['cp']) !== 5) {
            $inputsLengthOk = false;
        }
    }

    if (isset($_POST['ville'])) {
        if (strlen($_POST['ville']) > 25 || strlen($_POST['ville']) < 3) {
            $inputsLengthOk = false;
        }
    }

    return $inputsLengthOk;
}

// Vérification de champs vides --------------------------------------
function checkEmptyFields()
{
    foreach ($_POST as $field) {
        if (empty($field)) {
            return true;
        }
    }
    return false;
}

// Validation de la casse du MdP --------------------------------------
function checkPassword($mdp)
{
    // minimum 8 caractères et maximum 15, minimum 1 lettre, 1 chiffre et 1 caractère spécial
    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
    return preg_match($regex, $mdp);
}

// Fonction d'inscription --------------------------------------
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
            } else {

                if (!checkPassword($_POST['mdp'])) {
                    echo "<script>alert('Votre mot de passe ne correspond pas aux critères attendus')</script>";
                } else {

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
                        'id_client' => $id,
                        'adresse' => $_POST['adresse'],
                        'cp' => $_POST['cp'],
                        'ville' => $_POST['ville'],
                    ]);

                    echo "<script>alert('Votre inscription s'est déroulée avec succès !')</script>";
                }
            }
        }
    }
}

// Import de l'adresse liée au client --------------------------------------
function getAdresse()
{
    $db = getConnection();
    $query = $db->prepare('SELECT * FROM adresses WHERE id_client = ?');
    $query->execute([$_SESSION['id']]);
    return $query->fetch();
}

// Fonction de connexion à l'espace personnel --------------------------------------
function connection()
{
    // On vérifie qu'il n'y a pas de champs vides --------------------------------------
    if (checkEmptyFields()) {
        echo "<script>alert('Compléter les champs vides')</script>";
    } else {

        // On nomme le mail fourni par la personne qui souhaite se connecter ------------------------
        $client = verifyEmail($_POST['email']);

        // On vérifie que l'adresse email existe --------------------------------------
        if (empty($client)) {
            // LE MESSAGE NE S'AFFICHE PAS !!!!!
            echo "<script>alert('Cette adresse email n'existe pas !')</script>";
        } else {

            // On vérifie que le mot de passe correspond --------------------------------------
            if (!password_verify($_POST['mdp'], $client['mdp'])) {
                echo "<script>alert('Mot de passe erroné !')</script>";

                // Si toutes les validations sont OK alors on stocke les infos dans la SESSION ---------------
            } else {

                $_SESSION['id'] = $client['id'];
                $_SESSION['nom'] = $client['nom'];
                $_SESSION['prenom'] = $client['prenom'];
                $_SESSION['email'] = $client['email'];

                $adresse = getAdresse();

                $_SESSION['adresse'] = $adresse['adresse'];
                $_SESSION['cp'] = $adresse['cp'];
                $_SESSION['ville'] = $adresse['ville'];

                echo "<script>alert('Vous êtes bien connecté(e) !')</script>";
            }
        }
    }
}


// Fonction pour modifier les informations personnelles --------------------------------------
function modifIdentifiants()
{
    $db = getConnection();

    // On vérifie que l'adresse email n'existe pas déjà --------------------------------------
    if (verifyEmail($_POST['email'])) {
        echo "<script>alert('Cette adresse email est déjà utilisée !')</script>";
    } else {
        // On récupère toutes les infos du client via son email ------------------------
        $client = verifyEmail($_SESSION['email']);

        // On vérifie que le mot de passe correspond --------------------------------------
        if (!password_verify($_POST['mdp'], $client['mdp'])) {
            echo "<script>alert('Mot de passe erroné !')</script>";
        } else {

            $id = $_SESSION['id'];
            $nouveauNom = $_POST['nom'] != '' ? $_POST['nom'] : $_SESSION['nom'];
            $nouveauPrenom = $_POST['prenom'] != '' ? $_POST['prenom'] : $_SESSION['prenom'];
            $nouvelEmail = $_POST['email'] != '' ? $_POST['email'] : $_SESSION['email'];

            $sqlQuery = "UPDATE clients
                    SET nom = :nom, prenom = :prenom, email = :email
                    WHERE id = :id";
            $updateUser = $db->prepare($sqlQuery);
            $updateUser->execute([
                'nom' => $nouveauNom,
                'prenom' => $nouveauPrenom,
                'email' => $nouvelEmail,
                'id' => $id
            ]);

            $_SESSION['nom'] = $nouveauNom;
            $_SESSION['prenom'] = $nouveauPrenom;
            $_SESSION['email'] = $nouvelEmail;

            echo "<script>alert('Les modifications ont bien été prises en compte !')</script>";
        }
    }
}

function modifAdresse()
{
    $db = getConnection();
    // On récupère toutes les infos du client via son email ------------------------
    $client = verifyEmail($_SESSION['email']);

    // On vérifie que le mot de passe correspond --------------------------------------
    if (!password_verify($_POST['mdp'], $client['mdp'])) {
        echo "<script>alert('Mot de passe erroné !')</script>";
    } else {

        $id = $_SESSION['id'];
        $nouvelleAdresse = $_POST['adresse'] != '' ? $_POST['adresse'] : $_SESSION['adresse'];
        $nouveauCp = $_POST['cp'] != '' ? $_POST['cp'] : $_SESSION['cp'];
        $nouvelleVille = $_POST['ville'] != '' ? $_POST['ville'] : $_SESSION['ville'];

        $sqlQuery2 = "UPDATE adresses
            SET adresse = :adresse, cp = :cp, ville = :ville
            WHERE id_client = $id";
        $updateAdresse = $db->prepare($sqlQuery2);
        $updateAdresse->execute([
            'adresse' => $nouvelleAdresse,
            'cp' => $nouveauCp,
            'ville' => $nouvelleVille
        ]);

        $_SESSION['adresse'] = $nouvelleAdresse;
        $_SESSION['cp'] = $nouveauCp;
        $_SESSION['ville'] = $nouvelleVille;

        echo "<script>alert('Votre adresse a bien été modifiée !')</script>";
    }
}

function modifMdp()
{
    $db = getConnection();
    if (isset($_POST['newPwConfirm'])) {

        // On récupère toutes les infos du client via son email ------------------------
        $client = verifyEmail($_SESSION['email']);

        if (checkEmptyFields()) {
            echo "<script>alert('Compléter les champs vides')</script>";
        } else {

            // On vérifie que le mot de passe actuel correspond --------------------------------------
            if (!password_verify($_POST['oldPw'], $client['mdp'])) {
                echo "<script>alert('Mot de passe actuel erroné !')</script>";
            } else {

                // On vérifie que le nouveau mot de passe est identique aux deux endroits --------------------------------------
                if (($_POST['newPw'] != $_POST['newPwConfirm'])) {
                    echo "<script>alert('Les mots de passe ne correspondent pas !')</script>";
                } else {

                    $nouveauMdp = strip_tags($_POST['newPwConfirm']);

                    // On vérifie que le nouveau mot de passe respecte la casse --------------------------------------
                    if (!checkPassword($nouveauMdp)) {
                        echo "<script>alert('Votre mot de passe ne correspond pas aux critères attendus')</script>";
                    } else {

                        $id = $_SESSION['id'];

                        $sqlQuery = "UPDATE clients SET mdp = :mdp WHERE id = $id";
                        $updateMdp = $db->prepare($sqlQuery);
                        $updateMdp->execute([
                            'mdp' => password_hash($nouveauMdp, PASSWORD_DEFAULT)
                        ]);

                        echo "<script>alert('Votre mot de passe a bien été modifié !')</script>";
                    }
                }
            }
        }
    }
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
                        <h5 class=\"card-title fw-bold text-uppercase\">" .  $article['nom'] . "</h5>
                        <p class=\"card-text\"" . $article['description'] . " ?></p>
                        <p class=\"card-text\">" . $article['prix'] . " €</p>
                        <!-- Button trigger modal -->
                        <button type=\"button\" class=\"btn btn-outline-secondary m-2\" data-bs-toggle=\"modal\" data-bs-target=\"#detailArticle" .  $article['id'] . "\" style=\"background-color: white; border-color: darksalmon; color: darksalmon;\">Détails</button>
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


// ------------------------------------------------------------------------------
// FONCTIONS COMMANDE --------------------------------------

function saveOrder()
{
    $db = getConnection();
    $totalCommande = totalCommande();

    $sqlQuery = "INSERT INTO commandes (id_client, numero, date_commande, prix) VALUES (:id_client, :numero, :date_commande, :prix)";
    $insertNewOrder = $db->prepare($sqlQuery);
    $insertNewOrder->execute([
        'id_client' => $_SESSION['id'],
        'numero' => random_int(10000, 99999),
        'date_commande' => date('d-m-Y'),
        'prix' => $totalCommande
    ]);

    $id = $db->lastInsertId();

    $sqlQuery2 = 'INSERT INTO commandes_articles (id_commande, id_article, quantite) VALUES(:id_commande, :id_article, :quantite)';

    foreach ($_SESSION['cart'] as $article) {

        $insertArticle = $db->prepare($sqlQuery2);
        $insertArticle->execute([
            'id_commande' => $id,
            'id_article' => $article['id'],
            'quantite' => $article['quantite']
        ]);
    }
}
