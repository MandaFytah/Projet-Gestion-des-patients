<?php
include 'auth.php';
require_login();
include 'config.php';

// Vérifiez si la connexion à la base de données est bien établie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naissance = $_POST['date_naissance'];
        $adresse = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        $sql = "INSERT INTO Patients (nom, prenom, date_naissance, adresse, telephone, email) VALUES ('$nom', '$prenom', '$date_naissance', '$adresse', '$telephone', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Nouveau patient ajouté avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naissance = $_POST['date_naissance'];
        $adresse = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        $sql = "UPDATE Patients SET nom='$nom', prenom='$prenom', date_naissance='$date_naissance', adresse='$adresse', telephone='$telephone', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Patient modifié avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM Patients WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Patient supprimé avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Patients</title>
    <link rel="stylesheet" href="style.css">
    <!-- Inclure Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background-color: #4caf50; /* Couleur de fond verte */
            color: #fff; /* Couleur du texte en blanc */
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav a {
            color: #fff; /* Couleur du texte en blanc */
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #45a049; /* Couleur au survol */
            color: #e0e0e0; /* Couleur du texte au survol */
        }

        /* Style des modals */
        .modal {
            display: none; /* Masquer le modal par défaut */
            position: fixed; /* Rester en place */
            z-index: 1; /* Au-dessus des autres éléments */
            left: 0;
            top: 0;
            width: 100%; /* Pleine largeur */
            height: 100%; /* Pleine hauteur */
            overflow: auto; /* Activer le défilement si nécessaire */
            background-color: rgba(0,0,0,0.4); /* Fond noir transparent */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% du haut et centré */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Largeur du modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style des boutons et icônes */
        button i {
            color: #333; /* Couleur par défaut des icônes */
            font-size: 20px;
            transition: color 0.3s;
        }

        button i:hover {
            color: #007bff; /* Couleur des icônes au survol */
        }

        /* Style du formulaire de recherche */
        form {
            margin-bottom: 20px;
        }

        /* Style du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d9f9d9;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php"><i class="fas fa-home"></i> Accueil</a>
        <a href="patients.php"><i class="fas fa-user"></i> Patients</a>
        <a href="consultations.php"><i class="fas fa-calendar-check"></i> Consultations</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </nav>
    <h1>Gestion des Patients</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="">
        <label for="search">Rechercher:</label>
        <input type="text" id="search" name="search" placeholder="Rechercher" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <input type="submit" value="Rechercher">
    </form>

    <!-- Bouton pour afficher la modal d'ajout -->
    <button onclick="showAddModal()"><i class="fas fa-plus"></i> Ajouter un patient</button>

    <!-- Modal d'ajout -->
    <div id="addPatientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addPatientModal')">&times;</span>
            <form method="post" action="">
                <input type="hidden" name="id" id="add-patient-id">
                Nom: <input type="text" name="nom" id="add-nom" required><br>
                Prénom: <input type="text" name="prenom" id="add-prenom" required><br>
                Date de Naissance: <input type="date" name="date_naissance" id="add-date_naissance" required><br>
                Adresse: <input type="text" name="adresse" id="add-adresse" required><br>
                Téléphone: <input type="text" name="telephone" id="add-telephone" required><br>
                Email: <input type="email" name="email" id="add-email" required><br>
                <input type="submit" name="add" value="Ajouter">
            </form>
        </div>
    </div>

    <!-- Modal de modification -->
    <div id="editPatientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editPatientModal')">&times;</span>
            <form method="post" action="">
                <input type="hidden" name="id" id="edit-patient-id">
                Nom: <input type="text" name="nom" id="edit-nom" required><br>
                Prénom: <input type="text" name="prenom" id="edit-prenom" required><br>
                Date de Naissance: <input type="date" name="date_naissance" id="edit-date_naissance" required><br>
                Adresse: <input type="text" name="adresse" id="edit-adresse" required><br>
                Téléphone: <input type="text" name="telephone" id="edit-telephone" required><br>
                Email: <input type="email" name="email" id="edit-email" required><br>
                <input type="submit" name="update" value="Modifier">
            </form>
        </div>
    </div>

    <h2>Liste des Patients</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        // Récupérer la valeur de recherche
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Construire la requête SQL avec les critères de recherche
        $sql = "SELECT * FROM Patients WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['prenom'] . "</td>";
            echo "<td>" . $row['date_naissance'] . "</td>";
            echo "<td>" . $row['adresse'] . "</td>";
            echo "<td>" . $row['telephone'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>
                    <button onclick='editPatient(" . json_encode($row) . ")'><i class='fas fa-edit'></i></button>
                    <form method='post' action='' style='display:inline-block;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce patient?\")'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <script src="script.js"></script>
    <script>
        function showAddModal() {
            document.getElementById('addPatientModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function editPatient(patient) {
            document.getElementById('edit-patient-id').value = patient.id;
            document.getElementById('edit-nom').value = patient.nom;
            document.getElementById('edit-prenom').value = patient.prenom;
            document.getElementById('edit-date_naissance').value = patient.date_naissance;
            document.getElementById('edit-adresse').value = patient.adresse;
            document.getElementById('edit-telephone').value = patient.telephone;
            document.getElementById('edit-email').value = patient.email;
            document.getElementById('editPatientModal').style.display = 'block';
        }

        // Fermer les modals lorsque l'utilisateur clique en dehors d'elles
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                closeModal('addPatientModal');
                closeModal('editPatientModal');
            }
        }
    </script>
</body>
</html>
