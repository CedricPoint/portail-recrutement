<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Inscription</title>
</head>
<body>
    <header class="bg-primary text-white p-3" style="background-color: var(--secondary-color);">
        <div class="container">
            <h1>Portail de Recrutement PME</h1>
            <nav>
                <a href="index.php" class="text-link">Accueil</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="card p-4">
            <h2>Inscription</h2>
            <form action="inscription.php" method="POST">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de Passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <div class="form-group">
                    <label for="type_compte">Type de Compte</label>
                    <select class="form-control" id="type_compte" name="type_compte">
                        <option value="entreprise">Entreprise</option>
                        <option value="candidat">Candidat</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>

    <?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
        $type_compte = $_POST['type_compte'];

        // Préparer la requête SQL pour insérer un nouvel utilisateur
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, type_compte) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nom, $email, $mot_de_passe, $type_compte);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Inscription réussie. Vous pouvez maintenant vous connecter.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Erreur : " . $stmt->error . "</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>