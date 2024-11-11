<?php
session_start();
require __DIR__ . "/oauth_settings.php";
if (isset($_SESSION['token']) && isset($_SESSION['usuario'])) {
    $client = new Google\Client();
    $client->setAccessToken($_SESSION['token']['access_token']);
    $client->revokeToken();
    session_unset();
    session_destroy();
}
header("Location: index.php");
exit();
