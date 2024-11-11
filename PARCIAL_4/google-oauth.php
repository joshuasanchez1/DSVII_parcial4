<?php
session_start();
require __DIR__ . "/oauth_settings.php";

if (!isset($_GET['code'])) {
    exit("Login fallido");
}
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
$_SESSION["token"] = $token;
$client->setAccessToken($token["access_token"]);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();
$_SESSION['usuario'] = [
    'id' => $userinfo->id,
    'email' => $userinfo->email,
    'nombre' => $userinfo->name
];
header("Location: dashboard.php");
exit();
