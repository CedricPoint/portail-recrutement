<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Ajouter une Offre</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Ajouter une Offre d'Emploi</h1>
            <nav>
                <a href="tableau_bord_entreprise.php" class="text-link">Tableau de Bord</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Nouvelle Offre d'Emploi</h2>
            <form action="ajouter_offre.php" method="POST">
                <div class="form-group">
                    <label for="titre">Titre de l'Offre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="localisation">Localisation</label>
                    <input type="text" class="form-control" id="localisation" name="localisation" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter l'Offre</button>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>

    <?php
    // ajouter_offre.php - script pour traiter l'ajout d'une nouvelle offre
    include 'db.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: connexion.php");
            exit();
        }

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $localisation = $_POST['localisation'];
        $utilisateur_id = $_SESSION['utilisateur_id'];
        $date_creation = date('Y-m-d H:i:s');

        // Préparer la requête SQL pour insérer une nouvelle offre
        $sql = "INSERT INTO offres (titre, description, localisation, date_creation, utilisateur_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $titre, $description, $localisation, $date_creation, $utilisateur_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Offre ajoutée avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Erreur : " . $stmt->error . "</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>