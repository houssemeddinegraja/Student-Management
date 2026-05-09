<?php 
    session_start();
    require_once('connexion.php');
    $listlink = "etudiants_user.php";
    if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
        $listlink = "etudiants_admin.php";
    }
    if (isset($_GET['id']) && !empty($_GET['id'])){
        $id = $_GET['id'];
        $req = $db_cnx->prepare('
            SELECT e.id, e.image, e.name, e.birthday, s.Designation AS section
            FROM etudiants e
            JOIN sections s ON e.section = s.id
            WHERE e.id = :id
        ');
        $req->execute([':id' => $id]);
        $etudiant = $req->fetch(PDO::FETCH_ASSOC);
        if(!$etudiant){
            die('Étudiant non trouvé.');
        }
    } else {
        die("ID de l'étudiant manquant ou invalide.");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="infos.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="datatables.css">
    <link rel="stylesheet" href="etudiants_user.css">
    <title>Infos Etudiant</title>
    
</head>
<body>
    <header>
        <nav class="headBar">
            <ul>
                <li><h3>Students Management System</h3></li>
                <div class="navLinks">
                    <li><a href="welcome_page.php" target="_self">Home</a></li>
                    <li><a href="<?php echo $listlink; ?>" target="_self">Liste des étudiants</a></li>
                    <li><a href="sections.php" target="_self">Liste des sections</a></li>
                    <li><a href="#" target="_self">Logout</a></li>
                </div>
            </ul>
        </nav>
    </header>
    <section>
        <h1>A propos de cet étudiant</h1>
        <div class="student-details">
            <div class="student-image">
                <?php if (!empty($etudiant["image"])): ?>
                <img src="uploads/<?php echo htmlspecialchars($etudiant['image']); ?>" alt="Photo de l'étudiant" width="200">
                <?php else: ?>
                <img src="images/default_image.png" alt="Photo de l'étudiant" width="200" height="200">
                <?php endif; ?>
            </div>
        <div class="student-info">
            <p><strong>Nom:</strong> <?php echo htmlspecialchars($etudiant['name'] ?? 'N/A'); ?></p>
            <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($etudiant['birthday'] ?? 'N/A'); ?></p>
            <p><strong>Section:</strong> <?php echo htmlspecialchars($etudiant['section'] ?? 'N/A'); ?></p>
        
        </div>
        </div>
    </section>
</body>
</html>