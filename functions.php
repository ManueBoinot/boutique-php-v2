<?php

// FONCTIONS PRESENTES SUR TOUTES LES PAGES --------------------------------------

// Connexion à la BDD --------------------------------------
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

// Création de la session --------------------------------------
session_start();

// Définition du fuseau horaire --------------------------------------
date_default_timezone_set('Europe/Paris');

// Création du panier s'il n'existe pas déjà --------------------------------------
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


