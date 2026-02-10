<?php
// ma-page-de-traitement.php

// Configuration
$destinataire = 'delafosseb91@gmail.com'; // Remplacez par votre adresse email
$sujet = 'Nouveau message depuis votre portfolio';

// Vérification que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $nom = htmlspecialchars(trim($_POST['user_name']));
    $email = htmlspecialchars(trim($_POST['user_mail']));
    $message = htmlspecialchars(trim($_POST['user_message']));

    // Validation basique
    $erreurs = [];
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email est invalide.";
    }
    if (empty($message)) {
        $erreurs[] = "Le message est obligatoire.";
    }

    // Si pas d'erreurs, envoi de l'email
    if (empty($erreurs)) {
        // En-têtes de l'email
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Corps de l'email
        $corps_message = "Vous avez reçu un nouveau message depuis votre CV en ligne.\n\n";
        $corps_message .= "Nom: $nom\n";
        $corps_message .= "Email: $email\n";
        $corps_message .= "Message:\n$message\n";

        // Envoi de l'email
        if (mail($destinataire, $sujet, $corps_message, $headers)) {
            // Succès
            header('Location: index.html?success=1');
            exit();
        } else {
            // Échec de l'envoi
            header('Location: index.html?error=mail');
            exit();
        }
    } else {
        // Erreurs de validation
        header('Location: index.html?error=' . urlencode(implode('|', $erreurs)));
        exit();
    }
} else {
    // Requête non autorisée
    header('Location: index.html?error=method');
    exit();
}
?>
