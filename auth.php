<?php
session_start();
require_once('connexion.php');
if(isset($_POST['username'])&& isset($_POST['password'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if(empty($username) || empty($password)){
        $error = "Veuillez remplir tous les champs.";
    }
    else {
        $req = $db_cnx->prepare("
        SELECT *
        FROM auth
        WHERE username = ?
        AND password = ?
        ");
        $req->execute(array($username, $password));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if($result){
            $_SESSION["id"] = $result["id"];
            $_SESSION["username"] = $result["username"];
            if ($username == "admin") {
                $_SESSION["role"] = "admin";
                echo "<meta http-equiv='refresh' content='0;url=welcome_page.php'>";
                exit();
            } else if ($username == "user") {
                $_SESSION["role"] = "user";
                echo "<meta http-equiv='refresh' content='0;url=welcome_page.php'>";
                exit();
            }
        }
        else {
            $error = "Veuillez vérifier vos credentials.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="auth.css">
    
    <title>Authentification</title>
</head>
<body>
    <div class="container">   
        <form action="auth.php" method="post">
            Username: <br>
            <input id="username" type="text" name="username">
            
            Password: <br>
            <div class="password-container">
                <input id="password" type="password" name="password">
                <button id="togglePassword" type="button" onclick="toggle()">Show</button>
            </div>
            <br>
            
            <button id="login" type="submit">Login</button>
            <script src="auth.js" defer></script>
        </form>

    <?php if(!empty($error)) { ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="font-size: 14px;">
            <strong>Erreur:</strong> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>