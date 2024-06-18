<?php

/**
 * Pour PHP Storm
 * @var object $trajet
 */

include('header-init.php');
include('extraction-jwt.php');

if(!isset($_GET['id'])) {
    http_response_code(400);
    echo '{"message" : "il manque l\'identifiant dans l\'url"}';
    exit();
}

$idTravel = $_GET['id'];

$requete = $connexion->prepare('SELECT t.id, t.destination, t.seats FROM trajet AS t WHERE t.id = :id');

$requete->bindValue('id', $idTravel);

$requete->execute();

$trajet = $requete->fetch();

if (!$trajet) {
    http_response_code(404);
    echo '{"message" : "trajet introuvable"}';
    exit();
}

echo json_encode($trajet);
