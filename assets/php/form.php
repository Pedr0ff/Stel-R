<?php

// Configuration de l'adresse e-mail de destination
$to = 'votre@adresse-email.com'; // Remplacez par votre adresse e-mail

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $company_name = strip_tags(trim($_POST["company-name"]));
    $website = filter_var(trim($_POST["website"]), FILTER_VALIDATE_URL);
    $interest = '';
    if (isset($_POST["options-base"])) {
        $interest = strip_tags(trim($_POST["options-base"]));
    }
    $budget = '';
    if (isset($_POST["budget-options"])) {
        $budget = strip_tags(trim($_POST["budget-options"]));
    }
    $budget_defined = strip_tags(trim($_POST["budget"]));
    $timeline = strip_tags(trim($_POST["timeline"]));
    $message = strip_tags(trim($_POST["message"]));

    // Validation des données
    $errors = array();

    if (empty($name)) {
        $errors[] = 'Le nom est obligatoire.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'adresse e-mail n\'est pas valide.';
    }

    if (empty($message)) {
        $errors[] = 'Le message est obligatoire.';
    }

    // Si aucune erreur, envoi de l'e-mail
    if (empty($errors)) {
        $subject = "Nouveau message depuis le formulaire de contact";
        $body = "Nom: $name\n";
        $body .= "Email: $email\n";
        $body .= "Téléphone: $phone\n";
        $body .= "Nom de l'entreprise: $company_name\n";
        $body .= "Site web de l'entreprise: $website\n";
        $body .= "Intéressé par: $interest\n";
        $body .= "Budget (option): $budget\n";
        $body .= "Budget défini (texte): $budget_defined\n";
        $body .= "Disponibilités: $timeline\n";
        $body .= "Message:\n$message\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Envoi de l'e-mail
        if (mail($to, $subject, $body, $headers)) {
            echo "success"; // Indique au script JS que l'envoi a réussi
        } else {
            echo "error"; // Indique au script JS qu'une erreur s'est produite lors de l'envoi
        }

    } else {
        // Affichage des erreurs (pour le débogage, vous pouvez renvoyer ces erreurs au script JS)
        echo "validation_error";
        // print_r($errors);
    }

} else {
    // Si la requête n'est pas de type POST
    echo "invalid_request";
}

?>