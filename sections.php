<?php 
session_start();
$listlink = "etudiants_user.php";
if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    $listlink = "etudiants_admin.php";
}
require_once('connexion.php');
$req = $db_cnx->prepare('
        SELECT * FROM sections
');
$req->execute();
$sections = $req->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des sections</title>
    <link rel="stylesheet" href="etudiants_user.css">
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
        <h1>Liste des sections</h1>
            <div class="export">
                <button id="copyBtn" type="button">Copy</button>
                <button id="csvBtn" type="button">CSV</button>
                <button id="excelBtn" type="button">Excel</button>
                <button id="pdfBtn" type="button">PDF</button>
            </div>
        <table id="table_etud" style="margin-top: 20px;">
            <thead>
            <tr>
                <th>id</th>
                <th>designation</th>
                <th>description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php
                if (empty($sections)) {
                ?>
                    <tr>
                        <td colspan="4">Aucune section trouvé</td>
                     </tr>
                <?php
                } else {
                    foreach ($sections as $section) {  
                ?>

                <tr>
                    <td><?php echo htmlspecialchars($section['id']); ?></td>
                    <td><?php echo htmlspecialchars($section['Designation']); ?></td>
                    <td><?php echo htmlspecialchars($section['Description']); ?></td>
                    <td>
                        <button class="circular" type="button" onclick="window.location.href='<?php echo $listlink; ?>?section_id=<?php echo $section['id']; ?>'">
                        <img src="images\listicon.png" alt="Consulter" width="30" height="30" >
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
            $('#table_etud').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": false,
                "pageLength": 5
            });
        });
     
     </script>
</body>
</html>