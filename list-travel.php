<?php

/**
 * Pour PHP Storm
 * @var object $trajet
 */

include('header-init.php');
include('extraction-jwt.php');

$requete = $connexion->query('SELECT t.id , t.destination, t.seats
                              FROM trajet as t');

$trajets = $requete->fetchAll();

echo json_encode($trajets);
