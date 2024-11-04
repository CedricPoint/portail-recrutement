<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Postuler à une Offre</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Postuler à une Offre d'Emploi</h1>
            <nav>
                <a href="tableau_bord_candidat.php" class="text-link">Tableau de Bord</a>
                <a href="deconnexion.php" class="text-link">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Formulaire de Candidature</h2>
            <?php
            include 'db.php';
            session_start();

            // Vérifier si l'utilisateur est connecté
            if (!isset($_SESSION['utilisateur_id'])) {
                header("Location: connexion.php");
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
                $offre_id = $_GET['id'];
            ?>
            <form action="postuler.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Lettre de Motivation</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <div class="form-group">
                    <label for="cv">CV (PDF uniquement)</label>
                    <input type="file" class="form-control" id="cv" name="cv" accept="application/pdf" required>
                </div>
                <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($offre_id); ?>">
                <button type="submit" class="btn btn-primary">Envoyer la Candidature</button>
            </form>
            <?php
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nom = $_POST['nom'];
                $email = $_POST['email'];
                $message = $_POST['message'];
                $offre_id = $_POST['offre_id'];

                // Gérer l'upload du fichier CV
                if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                    $cv_tmp_name = $_FILES['cv']['tmp_name'];
                    $cv_name = basename($_FILES['cv']['name']);
                    $upload_dir = 'uploads/';
                    
                    // Créer le dossier uploads s'il n'existe pas
                    if (!is_dir($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            echo "<div class='alert alert-danger text-center'>Erreur lors de la création du dossier de destination.</div>";
                            exit();
                        }
                    }

                    $cv_path = $upload_dir . uniqid() . '_' . $cv_name;

                    if (move_uploaded_file($cv_tmp_name, $cv_path)) {
                        // Insérer la candidature dans la base de données
                        $sql = "INSERT INTO candidatures (offre_id, nom, email, message, cv_path) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("issss", $offre_id, $nom, $email, $message, $cv_path);

                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success text-center'>Votre candidature a été envoyée avec succès.</div>";
                        } else {
                            echo "<div class='alert alert-danger text-center'>Erreur : " . $stmt->error . "</div>";
                        }

                        $stmt->close();
                    } else {
                        echo "<div class='alert alert-danger text-center'>Erreur lors de l'upload du fichier CV. Veuillez vérifier les permissions du dossier.\n";
                        echo "<pre>Debug Info: \n";
                        echo "Temp file: " . $cv_tmp_name . "\n";
                        echo "Destination: " . $cv_path . "\n";
                        echo "Permissions du dossier: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
                        echo "</pre></div>";
                    }
                } else {
                    echo "<div class='alert alert-danger text-center'>Veuillez fournir un fichier CV valide.</div>";
                }

                $conn->close();
            } else {
                echo "<div class='alert alert-danger text-center'>ID de l'offre non fourni.</div>";
            }
            ?>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>
</body>
</html>