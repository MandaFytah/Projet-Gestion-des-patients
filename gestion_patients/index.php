<?php
include 'auth.php';
require_login();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }

        /* Style de la barre de navigation */
        nav {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #45a049;
            color: #e0e0e0;
        }

        /* Style du conteneur principal */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        /* Style des sections du tableau de bord */
        .dashboard-section {
            margin-bottom: 20px;
        }

        .dashboard-section h2 {
            font-size: 24px;
            color: #4caf50;
            border-bottom: 2px solid #4caf50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .dashboard-card {
            background-color: #4caf50;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .dashboard-card:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .dashboard-card i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .dashboard-card a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .dashboard-card a:hover {
            color: #e0e0e0;
        }

        /* Liens sous le tableau de bord */
        .dashboard-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .dashboard-links a {
            text-decoration: none;
            color: #4caf50;
            font-size: 18px;
            transition: color 0.3s;
        }

        .dashboard-links a:hover {
            color: #45a049;
        }

        /* Animation de l'apparition */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
    <div class="container">
        <h1>Bienvenue sur l'application de gestion des patients</h1>

        <div class="dashboard-section">
            <h2>Tableau de Bord</h2>
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <i class="fas fa-calendar-check"></i>
                    <a href="consultations.php">Consultations</a>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-users"></i>
                    <a href="patients.php">Patients</a>
                </div>
            
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
