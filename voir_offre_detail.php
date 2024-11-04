<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Détail de l'Offre d'Emploi</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Détail de l'Offre d'Emploi</h1>
            <nav>
                <a href="index.php" class="text-link">Accueil</a>
                <a href="connexion.php" class="text-link">Connexion</a>
                <a href="inscription.php" class="text-link">Inscription</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <?php
            include 'db.php';
            session_start();

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $offre_id = intval($_GET['id']);

                // Récupérer les détails de l'offre
                $sql = "SELECT titre, description, localisation, date_creation FROM offres WHERE id = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $offre_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<h2>" . htmlspecialchars($row['titre']) . "</h2>";
                        echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                        echo "<p><strong>Localisation:</strong> " . htmlspecialchars($row['localisation']) . "</p>";
                        echo "<p><strong>Date de création:</strong> " . htmlspecialchars($row['date_creation']) . "</p>";

                        if (isset($_SESSION['utilisateur_id'])) {
                            echo "<a href='postuler.php?id=" . $offre_id . "' class='btn btn-primary'>Postuler à cette offre</a>";
                        } else {
                            echo "<p class='mt-4'><a href='connexion.php' class='btn btn-secondary'>Connectez-vous pour postuler à cette offre</a></p>";
                        }
                    } else {
                        echo "<div class='alert alert-danger text-center'>Offre non trouvée. Veuillez vérifier l'ID de l'offre.</div>";
                    }

                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger text-center'>Erreur lors de la préparation de la requête. Veuillez contacter l'administrateur.</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center'>ID de l'offre non fourni ou invalide. Veuillez réessayer.</div>";
            }

            $conn->close();
            ?>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>
</body>
</html>