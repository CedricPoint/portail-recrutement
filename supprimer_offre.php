<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête SQL pour supprimer une offre
    $sql = "DELETE FROM offres WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Offre supprimée avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur : " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<a href="tableau_bord_entreprise.php" class="btn btn-primary">Retour au Tableau de Bord</a>