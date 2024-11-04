<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Connexion</title>
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
            <h2>Connexion</h2>
            <form action="connexion.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de Passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <button type="submit" class="btn btn-primary">Se Connecter</button>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white p-3 text-center">
        <p>&copy; 2024 Informaclique. Tous droits réservés.</p>
    </footer>

    <?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Préparer la requête SQL pour vérifier les informations de connexion
        $sql = "SELECT id, nom, mot_de_passe, type_compte FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                // Connexion réussie
                session_start();
                $_SESSION['utilisateur_id'] = $row['id'];
                $_SESSION['nom'] = $row['nom'];
                $_SESSION['type_compte'] = $row['type_compte'];
                
                if ($row['type_compte'] == 'entreprise') {
                    header("Location: tableau_bord_entreprise.php");
                } elseif ($row['type_compte'] == 'candidat') {
                    header("Location: tableau_bord_candidat.php");
                }
                exit();
            } else {
                echo "<div class='alert alert-danger text-center'>Mot de passe incorrect.</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center'>Aucun utilisateur trouvé avec cet email.</div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>