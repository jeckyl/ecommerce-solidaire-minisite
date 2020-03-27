<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbh = new PDO(
        getenv('DB_CONNECTION') . ':dbname=' . getenv('DB_DATABASE') . ';host=' . getenv('DB_HOST'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);

try {
    $variables = array(
        'NOM' => trim($_POST['lastname']),
        'PRENOM' => trim($_POST['firstname']),
        'TELEPHONE' => trim($_POST['phone']),
        'EMAIL' => trim($_POST['email']),
        'SOCIETE' => trim($_POST['rs']),
        'SIREN' => trim($_POST['siren']),
        'SALARIES' => trim($_POST['count']),
        'STATUT' => trim($_POST['statut']),
        'ADRESSE' => trim($_POST['address']),
        'CP' => trim($_POST['postcode']),
        'VILLE' => trim($_POST['city']),
        'COMMENTAIRES' => trim($_POST['description'])
    );

    // Insert in MYSQL
    $insert = "INSERT INTO inscriptions SET";
    foreach ($variables as $k => $v) {
        $insert .= ($k == key($variables) ? "" : ",") . " `" . strtolower($k) . "` = " . $dbh->quote($v);
    }
    $dbh->exec($insert);

    // Send email to the team
    $message_to_client = file_get_contents("tpl/contact_email.tpl");
    $from = 'contact@ecommerce-solidaire.fr';
    $to = 'contact@ecommerce-solidaire.fr';
    $subject = 'Contact via le mini-site Ecommercesolidaire';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From:" . $from;

    $message = preg_replace_callback('/{{([a-zA-Z0-9\_\-]*?)}}/i',
        function ($match) use ($variables) {
            return $variables[$match[1]];
        }, $message_to_client);

    if (!mail($to, $subject, $message, $headers)) {
        throw new Exception("Error email");
    }

    // Send welcome email
    if (!mail(
            $variables['EMAIL'],
            "Bienvenue dans l'initiative e-commerce solidaire",
            file_get_contents("tpl/welcome_email.tpl"),
            $headers
        )
    ) {
        throw new Exception("Error email welcome");
    }

    print "success";
} catch (Exception $e) {
    print 'error';
}