<?php 
session_start();
var_dump($_SESSION);
$listlink = "";
if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    $listlink .= "etudiants_admin.php";
}
else if (isset($_SESSION["role"]) && $_SESSION["role"] == "user") {
    $listlink .= "etudiants_user.php";
}
else {
    $listlink .= "auth.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire étudiants</title>
    <link rel="stylesheet" href="welcome_page.css">
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
    <h1>Hello, PHP LOVERS ! Welcome to your administration Platform</h1>
</body>
</html>