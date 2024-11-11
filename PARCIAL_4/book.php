<?php
session_start();
require __DIR__ . "/oauth_settings.php";
require __DIR__ . "/guardar_libro_favorito.php";


// Check if an ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit;
}

$bookId = $_GET['id'];
$booksService = new Google\Service\Books($client);
$userinfo = $_SESSION["usuario"];
$userId = $userinfo["id"];


try {
    $book = $booksService->volumes->get($bookId);
    $volumeInfo = $book->getVolumeInfo();
    $titulo = htmlspecialchars($volumeInfo->getTitle());
    echo '<h2>Detalles libro</h2>';
    echo '<p><strong>Titulo:</strong> ' . $titulo . '</p>';
    $imageLinks = $volumeInfo->getImageLinks();
    if (isset($imageLinks['thumbnail'])) {
        $portada = $imageLinks['thumbnail'];
        echo '<p><strong>Cover:</strong><br>';
        echo '<img src="' . $portada . '" alt="Book cover"></p>';
    } else {
        echo '<p><strong>Cover:</strong> Not available</p>';
    }

    $authors = $volumeInfo->getAuthors();
    if (is_array($authors)) {
        $autores = implode(', ', array_map('htmlspecialchars', $authors));
        echo '<p><strong>Authors:</strong> ' . $autores . '</p>';
    } else {
        echo '<p><strong>Authors:</strong> Not available</p>';
    }
    echo '<strong>Fecha publicacion:</strong> ' . htmlspecialchars($volumeInfo->getPublishedDate()) . "<br>";
    echo '<strong>Descripcion:</strong> ' . $volumeInfo->getDescription();
    echo '<strong>Paginas:</strong> ' . htmlspecialchars($volumeInfo->getPageCount()) . '<br>';
    $categorias = $volumeInfo->getCategories();
    if (is_array($categorias)) {
        echo '<strong>Categorias:</strong> ' . implode(', ', $categorias) . '<br>';
    } else {
        echo '<p><strong>Categorias:</strong> Not available</p>';
    }
} catch (Exception $e) {
    echo "Error retrieving book details: " . $e->getMessage();
}
echo $titulo;
if (isset($_POST['saveBook'])) {
    $userId = $_POST['userId'];
    $booksId = $_POST['booksId'];
    $titulo_libro = $_POST['titulo'];
    $autor = $_POST['autor'];
    $review = $_POST['review'];
    guardar_libro($conn, $userId, $booksId, $titulo_libro, $autor, $review);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Google OAuth Dashboard</title>
</head>

<body>
    <p>
    <form action="" method="POST">
        <input type="hidden" name="userId" value="<?php echo $userId?>">
        <input type="hidden" name="booksId" value="<?php echo $bookId; ?>">
        <input type="hidden" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">
        <input type="hidden" name="autor" value="<?php echo htmlspecialchars($autores); ?>">
        <textarea name="review" rows="4" cols="50" placeholder="Escribe tu critica aqui..."></textarea><br>
        <button type="submit" name="saveBook">Guardar a favoritos</button>
    </form>
        <a href="dashboard.php">Regresar al dashboard</a>
    </p>
</body>

</html>