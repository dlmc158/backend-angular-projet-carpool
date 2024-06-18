<?php

/**
 * Pour PHP Storm
 * @var object $trajet
 */

include('header-init.php');
include('extraction-jwt.php');

$json = file_get_contents('php://input');

$trajet = json_decode($json);

$requete = $connexion->prepare("INSERT INTO trajet 
                                (destination, seats) VALUES 
                                (:destination, :seats)");

$requete->bindValue("destination", $trajet->destination);
$requete->bindValue("seats", $trajet->seats);

$requete->execute();

echo '{"message" : "trajet ajouté"}';
