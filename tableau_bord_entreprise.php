<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Tableau de Bord Entreprise</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Tableau de Bord Entreprise</h1>
            <nav>
                <a href="index.php" class="text-link">Accueil</a>
                <a href="ajouter_offre.php" class="text-link">Ajouter une Offre</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="jumbotron">
            <h2>Vos Offres d'Emploi</h2>
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

                    $utilisateur_id = $_SESSION['utilisateur_id'];
                    $sql = "SELECT id, titre, description, localisation FROM offres WHERE utilisateur_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $utilisateur_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['localisation']) . "</td>";
                            echo "<td>";
                            echo "<a href='modifier_offre.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Modifier</a> ";
                            echo "<a href='supprimer_offre.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Supprimer</a> ";
                            echo "<a href='voir_candidatures.php?id=" . $row['id'] . "' class='btn btn-sm btn-success'>Voir Candidatures</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Aucune offre trouvée.</td></tr>";
                    }

                    $stmt->close();
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
