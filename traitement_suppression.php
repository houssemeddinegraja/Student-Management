<?php
session_start();
require_once('connexion.php');
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $req_image = $db_cnx->prepare("SELECT image FROM etudiants WHERE id = :id");
    $req_image->execute([':id' => $id]);
    $etudiant = $req_image->fetch(PDO::FETCH_ASSOC);
    if(!empty($etudiant['image'])) {
        $image_path = "uploads/" . $etudiant['image'];
        if(file_exists($image_path)) {
            unlink($image_path);
        }
    }
    $req = $db_cnx->prepare("DELETE FROM etudiants WHERE id = :id");
    $req->execute([':id' => $id]);
    header("Location: etudiants_admin.php");
    exit();
} else {
    echo "ID de l'étudiant manquant ou invalide.";
}
?>

