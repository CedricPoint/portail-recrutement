<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Modifier Offre</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Modifier une Offre d'Emploi</h1>
            <nav>
                <a href="tableau_bord_entreprise.php" class="text-link">Tableau de Bord</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Modifier Offre d'Emploi</h2>
            <?php
            include 'db.php';

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Préparer la requête pour obtenir les détails de l'offre
                $sql = "SELECT titre, description, localisation FROM offres WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($titre, $description, $localisation);
                $stmt->fetch();
                $stmt->close();
            }
            ?>
            <form action="modifier_offre.php" method="POST">
                <div class="form-group">
                    <label for="titre">Titre de l'Offre</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($titre); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="localisation">Localisation</label>
                    <input type="text" class="form-control" id="localisation" name="localisation" value="<?php echo htmlspecialchars($localisation); ?>" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Modifier l'Offre</button>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>

    <?php
    // modifier_offre.php - script pour traiter la modification d'une offre
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $localisation = $_POST['localisation'];

        // Préparer la requête SQL pour mettre à jour l'offre
        $sql = "UPDATE offres SET titre = ?, description = ?, localisation = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titre, $description, $localisation, $id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Offre modifiée avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Erreur : " . $stmt->error . "</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>