<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $numTel = $_POST['numTel'];


    $sql = "INSERT INTO Users (username, password,numTel) VALUES ('$username', '$password','$numTel')";
    if ($conn->query($sql) === TRUE) {
        header('Location: login.php');
    } else {
        $error = "Erreur: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="site-title">Gestion des patients</div>
    </header>
    <div class="cadre">
        <div class="form-container">
            <h2>Inscription</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" required><br>
                <label for="username">Numero telephone :</label>
                <input type="number" name="numTel" id="numTel" required><br>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required><br>
                <input type="submit" value="S'inscrire">
            </form>
            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
</body>
</html>
