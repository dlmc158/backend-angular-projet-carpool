<?php

/**
 * Pour PHP Storm
 * @var object $utilisateur
 */

include('header-init.php');
include('extraction-jwt.php');

if ($utilisateur->role != 'Administrateur') {
    echo '{"message":"Vous n\'avez pas les droits nécessaires"}';
    http_response_code(403);
    exit();
}

$json = file_get_contents('php://input');

$utilisateur = json_decode($json);

$requete = $connexion->prepare("SELECT id 
                                FROM role 
                                WHERE name = :name");

$requete->bindValue("name", $utilisateur->role);
$requete->execute();

$role = $requete->fetch();

if (!$role) {
    http_response_code(400);
    echo '{"message" : "Ce role n\'existe pas"}';
    exit();
}

$passwordHash = password_hash($utilisateur->password, PASSWORD_DEFAULT);

$requete = $connexion->prepare("INSERT INTO utilisateur 
                                (email, password, firstname, lastname, id_role) VALUES 
                                (:email, :password, :firstname, :lastname, :id_role)");

$requete->bindValue("email", $utilisateur->email);
$requete->bindValue("password", $passwordHash);
$requete->bindValue("firstname", $utilisateur->firstname);
$requete->bindValue("lastname", $utilisateur->lastname);
$requete->bindValue("id_role", $role['id']);

$requete->execute();

echo '{"message" : "inscription réussie"}';
