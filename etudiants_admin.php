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
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="datatables.css">
    <link rel="stylesheet" href="etudiants_user.css">
    <title>Liste des étudiants - Admin</title>
    
</head>
<body>
    <header>
        <nav class="headBar">
            <ul>
                <li><h3>Students Management System</h3></li>
                <div class="navLinks">
                    <li><a href="welcome_page.php" target="_self">Home</a></li>
                    <li><a href="etudiants_admin.php" target="_self">Liste des étudiants</a></li>
                    <li><a href="sections.php" target="_self">Liste des sections</a></li>
                    <li><a href="#" target="_self">Logout</a></li>
                </div>
            </ul>
        </nav>
    </header>
    <section>
        <h1>Liste des étudiants</h1>
        <div class="top-controls">
    
    <div class="Search">
        <button id="addBtn" type="button" onclick="window.location.href='ajouter.php'">Ajouter</button>
    </div>
    
    <div class="export">
        <button id="copyBtn" type="button">Copy</button>
        <button id="csvBtn" type="button">CSV</button>
        <button id="excelBtn" type="button">Excel</button>
        <button id="pdfBtn" type="button">PDF</button>
    </div>

</div>
        <table id="table_etud">
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
                if(empty($etudiants)) { 
                ?>
                    <tr>
                        <td colspan="6">
                            <strong>Aucun étudiant trouvé.</strong>
                        </td>
                    </tr>
                <?php 
                } else { 
                    foreach($etudiants as $etudiant) { 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($etudiant['id']); ?></td>
                        
                        <td>
                            <?php if (!empty($etudiant['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($etudiant['image']); ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                <img src="images/default_image.png" width="50" height="50" style="object-fit: cover; border-radius: 5px;" alt="Pas de photo">
                            <?php endif; ?>
                        </td>
                        
                        <td><?php echo htmlspecialchars($etudiant['name']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['birthday']); ?></td>
                        <td><?php echo htmlspecialchars($etudiant['section']); ?></td>
                        
                        <td>
                            <button class="circular" type="button" onclick="window.location.href='infos.php?id=<?php echo htmlspecialchars($etudiant['id']); ?>'"><img src="images\infobutton.png" alt="Consulter" width="30" height="30" ></button>
                            <button class="circular" type="button" onclick="window.location.href='maj.php?id=<?php echo htmlspecialchars($etudiant['id']); ?>'"><img src="images\editicon-removebg.png" alt="Modifier" width="30" height="30"></button>
                            <button class="circular" type="button" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) { window.location.href='traitement_suppression.php?id=<?php echo htmlspecialchars($etudiant['id'] ?? ''); ?>'; }">
                                <img src="images\deleteicon.png" alt="Supprimer" width="30" height="30">
                            </button>
                         </td>
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
            var table = $('#table_etud').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": false,
                "pageLength": 5,
                "autoWidth": false,
                "buttons": ['copy', 'csv', 'excel', 'pdf']
            });
            $('#copyBtn').on('click', function() {
                table.button('.buttons-copy').trigger();
            });
            $('#csvBtn').on('click', function() {
                table.button('.buttons-csv').trigger();
            });
            $('#excelBtn').on('click', function() {
                table.button('.buttons-excel').trigger();
            });
            $('#pdfBtn').on('click', function() {
                table.button('.buttons-pdf').trigger();
            });

        });
     </script>
</body>
</html>


