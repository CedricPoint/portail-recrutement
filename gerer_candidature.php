<?php
include 'db.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['candidature_id'])) {
        $candidature_id = $_POST['candidature_id'];
        $utilisateur_id = $_SESSION['utilisateur_id'];

        // Vérifier si la candidature appartient bien à une offre de l'utilisateur
        $sql_verif = "SELECT c.id FROM candidatures c INNER JOIN offres o ON c.offre_id = o.id WHERE c.id = ? AND o.utilisateur_id = ?";
        $stmt_verif = $conn->prepare($sql_verif);
        $stmt_verif->bind_param("ii", $candidature_id, $utilisateur_id);
        $stmt_verif->execute();
        $result_verif = $stmt_verif->get_result();

        if ($result_verif->num_rows > 0) {
            if (isset($_POST['traiter'])) {
                // Marquer la candidature comme traitée
                $sql = "UPDATE candidatures SET statut = 'Traitée' WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $candidature_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Candidature marquée comme traitée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de la candidature.";
                }

                $stmt->close();
            } elseif (isset($_POST['supprimer'])) {
                // Supprimer la candidature
                $sql = "DELETE FROM candidatures WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $candidature_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Candidature supprimée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de la candidature.";
                }

                $stmt->close();
            }
        } else {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à gérer cette candidature.";
        }

        $stmt_verif->close();
    }
}

$conn->close();
header("Location: tableau_bord_entreprise.php");
exit();
?>
