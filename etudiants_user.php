<?php
session_start();
require_once('connexion.php');
if(isset($_GET['section_id']) && !empty($_GET['section_id'])) {
    $req = $db_cnx->prepare('
            SELECT e.id, e.image, e.name, e.birthday, s.Designation AS section
            FROM etudiants e
            JOIN sections s ON e.section = s.id
            WHERE s.id = :section_id
            ORDER BY e.id;
    ');
    $req->execute(['section_id' => $_GET['section_id']]);
    $etudiants = $req->fetchAll(PDO::FETCH_ASSOC);
} else {
    $req = $db_cnx->prepare('
            SELECT e.id, e.image, e.name, e.birthday, s.Designation AS section
            FROM etudiants e
            JOIN sections s ON e.section = s.id
            ORDER BY e.id;
    ');
    $req->execute();
    $etudiants = $req->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="datatables.css">
    <link rel="stylesheet" href="etudiants_user.css">
    <title>Liste des étudiants</title>
    
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
        <h1>Liste des étudiants</h1>

            <div class="export">
                <button id="copyBtn" type="button">Copy</button>
                <button id="csvBtn" type="button">CSV</button>
                <button id="excelBtn" type="button">Excel</button>
                <button id="pdfBtn" type="button">PDF</button>
            </div>

        <table id="table_etud" style="margin-top:20px;">
            <thead>
                <tr class="trait">
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                // Vérification si la base de données a retourné des résultats
                if(empty($etudiants)) { 
                ?>
                    <tr>
                        <td colspan="6">
                            <strong>Aucun étudiant trouvé.</strong>
                        </td>
                    </tr>
                <?php 
                } else { 
                    // S'il y a des étudiants, on boucle sur chaque ligne
                    foreach($etudiants as $etudiant) { 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($etudiant['id']); ?></td>
                        
                        <td>
                            <img src="uploads/<?php echo htmlspecialchars($etudiant['image']);?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                        </td>
                        
                        <td><?php echo htmlspecialchars($etudiant['name']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['birthday']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['section']); ?></td>
                        
                        <td>
                            <button class="circular" type="button" onclick="window.location.href='infos.php?id=<?php echo htmlspecialchars($etudiant['id']); ?>'">
                            <img src="images\infobutton.png" alt="Consulter" width="30" height="30" >
                            </button>  </td>
                    </tr>
                <?php 
                    }
                } 
                ?>
            </tbody>
        </table>
    </section>
      <script>
        $(document).ready(function() {
            $('#table_etud').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": false,
                "pageLength": 5,
                "autoWidth": false
            });
        });
     </script>
</body>
</html>