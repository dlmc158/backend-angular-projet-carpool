<?php

/**
 * Pour PHP Storm
 * @var object $trajet
 */

include('header-init.php');
include('extraction-jwt.php');

$json = file_get_contents('php://input');

$trajet = json_decode($json);

$requete = $connexion->prepare("SELECT id FROM trajet");
$requete->execute();

//si il n'y a pas de parametre "id" dans l'url
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo '{"message" : "Il manque dans l\'url l\'identifiant du trajet à modifier"}';
    exit();
}

//on recupère l'ancien trajet dans la base de données
$requete = $connexion->prepare("SELECT * 
                                FROM trajet 
                                WHERE id = :id");

$requete->bindValue("id", $_GET['id']);
$requete->execute();
$trajetBdd = $requete->fetch();

//si le trajet n'existe pas on envoie une erreur 404
if (!$trajetBdd) {
    http_response_code(404);
    echo '{"message" : "Le trajet n\'existe pas / plus"}';
    exit();
}

$requete = $connexion->prepare("UPDATE trajet 
                                SET destination = :destination, 
                                    seats = :seats 
                                WHERE id = :id");

$requete->bindValue("destination", $trajet->destination);
$requete->bindValue("seats", $trajet->seats);
$requete->bindValue("id", $_GET['id']);

$requete->execute();

echo '{"message" : "Modification réussie"}';
