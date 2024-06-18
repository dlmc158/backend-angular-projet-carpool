<?php

/**
 * Pour PHP Storm
 * @var object $trajet
 */

include('header-init.php');
include('extraction-jwt.php');

$idTrajetAsupprimer = $_GET['id'];

$requete = $connexion->prepare("DELETE FROM trajet WHERE id = :id");

$requete->bindValue('id', $idTrajetAsupprimer);

$requete->execute();

echo '{"message" : "Le trajet a bien été supprimé"}';
