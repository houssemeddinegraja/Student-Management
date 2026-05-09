<?php 
session_start();
$listlink = "etudiants_user.php";
if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    $listlink = "etudiants_admin.php";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier étudiant</title>
    <link rel="stylesheet" href="ajouter.css">
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
        <fieldset>
            <legend><h2>Modifier un étudiant</h2></legend>
            <form action="traitement_maj.php" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
            name: <br><input type="text" name="name" style="width:100%"><br><br>
            Date de naissance: <br><input type="date" name="birthday" style="width:100%" max="<?php echo date('Y-m-d'); ?>"><br><br>
            Section:<br><select name="section" style="width:100%">
                <option value="1">GL</option>
                <option value="2">RT</option>
                <option value="3">IIA</option>
                <option value="4">IMI</option>
                </select>
            <br><br>
            <button id="submit" type="submit">Submit</button>
        </fieldset>
    </section>
</body>
</html>
