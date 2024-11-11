<?php
session_start();
require __DIR__ . "/oauth_settings.php";
require __DIR__ . "/usuarios_functions.php";
if (!isset($_SESSION['usuario']) || !isset($_SESSION['token'])) {
    header("Location: index.php");  // Redirect to login page if not logged in
    exit();
}

$userinfo = $_SESSION['usuario'];
$token = $_SESSION['token'];

echo "<pre>";
print_r($userinfo);
echo "</pre>";
echo "<pre>";
print_r($token);
echo "</pre>";
$name = $userinfo["nombre"];
$email = $userinfo["email"];
$id = $userinfo["id"];
if (usuario_existe($conn, $email)) {
    echo "Usuario registrado";
} else {
    guardar_usuario($conn, $email, $name, $id);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Google OAuth Dashboard</title>
</head>

<body>
    <p><?php $name ?></p>
    <h3>Bienvenido! <?php htmlspecialchars($name) ?></h3>
    <br>
    <h1>Buscar Libros</h1>

    <!-- Buscar libros -->
    <form action="booksapi.php" method="GET">
        <input type="text" name="query" placeholder="Ingresa titulo, autor etc." required>
        <button type="submit">Buscar</button>
    </form>
    <br>
    <a href="ver_libros.php">Ver Libros Favoritos</a>
    <br>
    <a href="logout.php">Logout</a>
</body>

</html>