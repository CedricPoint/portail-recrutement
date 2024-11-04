<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Voir les Offres d'Emploi</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Voir les Offres d'Emploi</h1>
            <nav>
                <a href="index.php" class="text-link">Accueil</a>
                <a href="connexion.php" class="text-link">Connexion</a>
                <a href="inscription.php" class="text-link">Inscription</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Liste des Offres d'Emploi</h2>
            <table class="table table-dark table-hover mt-4">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Localisation</th>
                        <th>Date de Création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    session_start();

                    // Récupérer toutes les offres d'emploi
                    $sql = "SELECT id, titre, description, localisation, date_creation FROM offres";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                            echo "<td>" . htmlspecialchars(substr($row['description'], 0, 50)) . "...</td>";
                            echo "<td>" . htmlspecialchars($row['localisation']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['date_creation']) . "</td>";
                            echo "<td><a href='voir_offre_detail.php?id=" . $row['id'] . "' class='btn btn-sm btn-info'>Voir Détails</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Aucune offre d'emploi disponible pour le moment.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>
</body>
</html>