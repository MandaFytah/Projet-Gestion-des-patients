<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM Users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: index.php');
            exit();
        }
    }
    $error = "Nom d'utilisateur ou mot de passe incorrect";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="site-title">Gestion des patients</div>
    </header>
    <div class="cadre">
        <div class="form-container">
            <h2>Connexion</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" required><br>
                <label for="numTel">Mot de passe :</label>
                <input type="password" name="password" id="password" required><br>
                <input type="submit" value="Se connecter">
            </form>
            <p>Pas encore inscrit ? <a href="register.php">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>
