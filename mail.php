<?php
require 'vendor/autoload.php';

$message_to_client = file_get_contents("tpl/contact_email.tpl");
$from = 'contact@ecommerce-solidaire.fr';
$to = 'contact@ecommerce-solidaire.fr';
// pour tests
//$from = 'peter.julia@web-rd-info.fr';
//$to = 'peter.julia@web-rd-info.fr';
$subject = 'Contact via le mini-site Ecommercesolidaire';
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= "From:".$from;

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

if (
    empty($variables['NOM']) OR
    empty($variables['PRENOM']) OR
    empty($variables['TELEPHONE']) OR
    filter_var($variables['EMAIL'], FILTER_VALIDATE_EMAIL) === false OR
    empty($variables['SOCIETE']) OR
    !in_array($variables['SALARIES'], array('0-20', '21-50', '50-')) OR
    !in_array($variables['STATUT'], array('SARL', 'SASU', 'SAS', 'EURL', 'Micro', 'Autre')) OR
    empty($variables['CP']) OR
    empty($variables['VILLE']) OR
    empty($variables['COMMENTAIRES'])
) {
    print "error";
    die;
}

$message = preg_replace_callback('/{{([a-zA-Z0-9\_\-]*?)}}/i',
    function ($match) use ($variables) {
        return $variables[$match[1]];
    }, $message_to_client);

if (!mail($to, $subject, $message, $headers)) {
    print "error";
} else {
    print "success";
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/* Connexion à une base MySQL avec l'invocation de pilote */
$dsn = getenv('DB_CONNECTION') . ':dbname=' . getenv('DB_DATABASE') . ';host=' . getenv('DB_HOST');
$user = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

$insert = "INSERT INTO inscriptions SET";
foreach ($variables as $k => $v) {
    $insert .= ($k == key($variables) ? "" : ",") . " `" . strtolower($k) . "` = " . $dbh->quote($v);
}
try {
    $dbh->exec($insert);
} catch (PDOException $e) {
    echo 'Insert échouée : ' . $e->getMessage();
}