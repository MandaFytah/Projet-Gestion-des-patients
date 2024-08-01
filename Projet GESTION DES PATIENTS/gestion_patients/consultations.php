<?php
include 'auth.php';
require_login();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $patient_id = $_POST['patient_id'];
        $date_consultation = $_POST['date_consultation'];
        $notes = $_POST['notes'];

        $sql = "INSERT INTO Consultations (patient_id, date_consultation, notes) VALUES ('$patient_id', '$date_consultation', '$notes')";
        if ($conn->query($sql) === TRUE) {
            echo "Nouvelle consultation ajoutée avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $patient_id = $_POST['patient_id'];
        $date_consultation = $_POST['date_consultation'];
        $notes = $_POST['notes'];

        $sql = "UPDATE Consultations SET patient_id='$patient_id', date_consultation='$date_consultation', notes='$notes' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Consultation modifiée avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM Consultations WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Consultation supprimée avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }
}

$search_date = isset($_POST['search_date']) ? $_POST['search_date'] : '';

$sql = "SELECT * FROM Consultations";
if ($search_date) {
    $sql .= " WHERE date_consultation = '$search_date'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Consultations</title>
    <link rel="stylesheet" href="style.css">
    <!-- Inclure Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            background-color: rgba(0, 0, 0, 0.4); /* Fond noir transparent */
            opacity: 0; /* Opacité initiale */
            transition: opacity 0.5s ease; /* Transition d'opacité */
        }

        .modal.show {
            display: block; /* Afficher le modal */
            opacity: 1; /* Opacité à 1 lors de l'affichage */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% du haut et centré */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Largeur du modal */
            transform: translateY(-50px); /* Déplacement vers le haut */
            transition: transform 0.5s ease; /* Transition pour le mouvement */
        }

        .modal.show .modal-content {
            transform: translateY(0); /* Remise à sa position d'origine */
        }

        /* Styles du tableau */
        table {
            width: 100%;
            border-collapse: collapse; /* Supprime l'espace entre les cellules */
            background-color: #eafaf1; /* Fond vert clair pour le tableau */
        }

        th, td {
            border: 1px solid #ddd; /* Bordure légère */
            padding: 8px; /* Réduit l'espacement interne */
            text-align: left; /* Alignement à gauche du texte */
        }

        th {
            background-color: #4caf50; /* Fond vert pour les en-têtes */
            color: white; /* Couleur du texte en blanc pour les en-têtes */
        }

        tr:nth-child(even) {
            background-color: #c1d5c4; /* Couleur de fond alternée pour les lignes */
        }

        tr:hover {
            background-color: #a0c8a0; /* Couleur de fond lors du survol */
        }

        /* Style des boutons avec icônes */
        button i {
            color: #333; /* Couleur par défaut des icônes */
            font-size: 20px;
            transition: color 0.3s;
        }

        button i:hover {
            color: #007bff; /* Couleur des icônes au survol */
        }

        /* Style du formulaire dans les modals */
        form {
            display: flex;
            flex-direction: column;
        }

        input[type="submit"] {
            margin-top: 10px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Style de la barre de navigation */
        nav {
            background-color: #4caf50; /* Fond vert pour la barre de navigation */
            padding: 10px;
            color: white;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #45a049; /* Couleur de survol pour les liens de navigation */
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
    <h1>Gestion des Consultations</h1>

    <!-- Formulaire de recherche par date -->
    <form method="post" action="">
        <label for="search_date">Rechercher par date de consultation:</label>
        <input type="date" name="search_date" id="search_date" value="<?php echo htmlspecialchars($search_date); ?>">
        <input type="submit" value="Rechercher">
    </form>

    <!-- Bouton pour afficher la modal d'ajout -->
    <button onclick="showAddModal()"><i class="fas fa-plus"></i> Ajouter une consultation</button>

    <!-- Modal d'ajout -->
    <div id="addConsultationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addConsultationModal')">&times;</span>
            <form method="post" action="">
                <input type="hidden" name="id" id="consultation-id">
                ID du Patient: <input type="text" name="patient_id" id="add-patient_id" required><br>
                Date de Consultation: <input type="date" name="date_consultation" id="add-date_consultation" required><br>
                Notes: <textarea name="notes" id="add-notes" required></textarea><br>
                <input type="submit" name="add" value="Ajouter">
            </form>
        </div>
    </div>

    <!-- Modal de modification -->
    <div id="editConsultationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editConsultationModal')">&times;</span>
            <form method="post" action="">
                <input type="hidden" name="id" id="edit-consultation-id">
                ID du Patient: <input type="text" name="patient_id" id="edit-patient_id" required><br>
                Date de Consultation: <input type="date" name="date_consultation" id="edit-date_consultation" required><br>
                Notes: <textarea name="notes" id="edit-notes" required></textarea><br>
                <input type="submit" name="update" value="Modifier">
            </form>
        </div>
    </div>

    <h2>Liste des Consultations</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ID du Patient</th>
            <th>Date</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
        <?php
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['patient_id'] . "</td>";
            echo "<td>" . $row['date_consultation'] . "</td>";
            echo "<td>" . $row['notes'] . "</td>";
            echo "<td>
                    <button onclick='editConsultation(" . json_encode($row) . ")'><i class='fas fa-edit'></i></button>
                    <form method='post' action='' style='display:inline-block;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette consultation?\")'>
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
            document.getElementById('addConsultationModal').classList.add('show'); // Ajouter la classe show
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show'); // Retirer la classe show
        }

        function editConsultation(consultation) {
            document.getElementById('edit-consultation-id').value = consultation.id;
            document.getElementById('edit-patient_id').value = consultation.patient_id;
            document.getElementById('edit-date_consultation').value = consultation.date_consultation;
            document.getElementById('edit-notes').value = consultation.notes;
            document.getElementById('editConsultationModal').classList.add('show'); // Ajouter la classe show
        }

        // Fermer les modals lorsque l'utilisateur clique en dehors d'elles
        window.onclick = function(event) {
            if (event.target.className === 'modal show') {
                closeModal('addConsultationModal');
                closeModal('editConsultationModal');
            }
        }
    </script>
</body>
</html>
