<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Voir les Candidatures</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Voir les Candidatures</h1>
            <nav>
                <a href="tableau_bord_entreprise.php" class="text-link">Tableau de Bord</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Candidatures Reçues</h2>
            <table class="table table-dark table-hover mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du Candidat</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date de Candidature</th>
                        <th>CV</th>
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

                    if (isset($_GET['id'])) {
                        $offre_id = $_GET['id'];
                        $utilisateur_id = $_SESSION['utilisateur_id'];

                        // Vérifier si l'utilisateur est bien le propriétaire de l'offre
                        $sql_verif = "SELECT id FROM offres WHERE id = ? AND utilisateur_id = ?";
                        $stmt_verif = $conn->prepare($sql_verif);
                        $stmt_verif->bind_param("ii", $offre_id, $utilisateur_id);
                        $stmt_verif->execute();
                        $result_verif = $stmt_verif->get_result();

                        if ($result_verif->num_rows > 0) {
                            // Récupérer les candidatures pour l'offre
                            $sql = "SELECT id, nom, email, message, date_candidature, cv_path, statut FROM candidatures WHERE offre_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $offre_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['date_candidature']) . "</td>";
                                    echo "<td><a href='" . htmlspecialchars($row['cv_path']) . "' target='_blank' class='btn btn-sm btn-info'>Voir CV</a></td>";
                                    echo "<td>";
                                    echo "<form action='gerer_candidature.php' method='POST' style='display:inline-block;'>";
                                    echo "<input type='hidden' name='candidature_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' name='traiter' class='btn btn-sm btn-success'>Marquer comme Traitée</button> ";
                                    echo "<button type='submit' name='supprimer' class='btn btn-sm btn-danger'>Supprimer</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>Aucune candidature reçue pour cette offre.</td></tr>";
                            }

                            $stmt->close();
                        } else {
                            echo "<div class='alert alert-danger text-center'>Vous n'êtes pas autorisé à voir les candidatures pour cette offre.</div>";
                        }

                        $stmt_verif->close();
                    } else {
                        echo "<div class='alert alert-danger text-center'>ID de l'offre non fourni.</div>";
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
