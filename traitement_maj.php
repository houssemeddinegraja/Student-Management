<?php
session_start();
require_once('connexion.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $date = date('Y-m-d');
    if ($birthday > $date){
        die("Erreur : La date de naissance ne peut pas être dans le futur.");
    }
    try {
        $query = $db_cnx->prepare('
            UPDATE etudiants
            SET name = :name, birthday = :birthday, section = :section
            WHERE id = :id;
        ');
        $query->execute(array(
            ':name' => $name,
            ':birthday' => $birthday,
            ':section' => $section,
            ':id' => $id
        ));
        echo '<meta http-equiv="refresh" content="0;url=etudiants_admin.php">';
        exit();
    }
    catch (PDOException $e) {
        echo "Erreur lors de la modification: " . $e->getMessage();
    }
}