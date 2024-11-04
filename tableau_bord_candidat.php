<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Tableau de Bord Candidat</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Tableau de Bord Candidat</h1>
            <nav>
                <a href="index.php" class="text-link">Accueil</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Offres Disponibles</h2>
            <table class="table table-dark table-hover mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre de l'Offre</th>
                        <th>Description</th>
                        <th>Localisation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    session_start();

                    // Vérifier si l'utilisateur est connecté
                    if (!isset($_SESSION['utilisateur_id'])) {
                        header("Location: connexion.php");
                        exit();
                    }

                    $sql = "SELECT id, titre, description, localisation FROM offres";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['localisation']) . "</td>";
                            echo "<td>";
                            echo "<a href='postuler.php?id=" . $row['id'] . "' class='btn btn-sm btn-success'>Postuler</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Aucune offre disponible.</td></tr>";
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