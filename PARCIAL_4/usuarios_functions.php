<?php
require_once "config_mysqli.php";


function guardar_usuario($conn, $email, $nombre, $googleId)
{
    $email = mysqli_real_escape_string($conn, $email);
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $googleId = mysqli_real_escape_string($conn, $googleId);
    $sql = "INSERT INTO usuarios (email, nombre, google_id) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $email, $nombre, $googleId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: No se pudo preparar la consulta.";
    }
    mysqli_close($conn);
}

function usuario_existe($conn, $email)
{
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            return true;
        } else {
            return false;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: No se pudo preparar la consulta.";
        return false;
    }
}
