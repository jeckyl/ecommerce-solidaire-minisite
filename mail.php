<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 18/03/2020
 * Time: 16:02
 */
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

$message = preg_replace_callback('/{{([a-zA-Z0-9\_\-]*?)}}/i',
    function ($match) use ($variables) {
        return $variables[$match[1]];
    }, $message_to_client);

if (!mail($to, $subject, $message, $headers)) {
    print "error";
} else {
    print "success";
}