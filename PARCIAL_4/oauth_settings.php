<?php
require __DIR__ . "../../../vendor/autoload.php";
$client = new Google\Client;
$googleCredentials = json_decode(file_get_contents("credentials.json"), true);
$client_id = $googleCredentials["web"]["client_id"];
$client_secret = $googleCredentials["web"]["client_secret"];
$redirect_uris = $googleCredentials["web"]["redirect_uris"][0];
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uris);
