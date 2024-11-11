<?php
require_once "config_mysqli.php";

function guardar_libro($conn, $userId, $booksId, $titulo, $autor, $review)
{
    $userId = mysqli_real_escape_string($conn, $userId);
    $booksId = mysqli_real_escape_string($conn, $booksId);
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $autor = mysqli_real_escape_string($conn, $autor);
    $review = mysqli_real_escape_string($conn, $review);
    $sql = "INSERT INTO libros_guardados (user_id, google_books_id, titulo, autor, reseña_personal) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $userId, $booksId, $titulo, $autor, $review);
        if (mysqli_stmt_execute($stmt)) {
            echo "Libro guardado con éxito.";
        } else {
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: No se pudo preparar la consulta.";
    }
    mysqli_close($conn);
}
