<?php
session_start();
require __DIR__ . "/oauth_settings.php";

$booksService = new Google\Service\Books($client);

$query = isset($_GET['query']) ? $_GET['query'] : '';


function buscarLibros($booksService, $query)
{
    try {
        $results = $booksService->volumes->listVolumes(['q' => $query]);

        if (count($results->getItems()) > 0) {
            echo '<table border="1">';
            echo '<tr><th>Title</th><th>Authors</th><th>Published Date</th><th>Action</th></tr>';

            foreach ($results->getItems() as $item) {
                $volumeInfo = $item->getVolumeInfo();
                $title = htmlspecialchars($volumeInfo->getTitle());
                if (empty($title)) {
                    continue;
                }
                $authors = $volumeInfo->getAuthors();
                $publishedDate = htmlspecialchars($volumeInfo->getPublishedDate());

                echo '<tr>';
                echo '<td>' . $title . '</td>';
                if (is_array($authors)) {
                    echo '<td>' . implode(', ', array_map('htmlspecialchars', $authors)) . '</td>';
                } else {
                    echo '<td>No disponible</td>';
                }

                echo '<td>' . $publishedDate . '</td>';
                // Add button with link to the book entry
                echo '<td><a href="book.php?id=' . urlencode($item->getId()) . '">';
                echo '<button>View Details</button>';
                echo '</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No books found.";
        }
    } catch (Exception $e) {
        echo "error: " . $e->getMessage();
    }
}

if (!empty($query)) {
    buscarLibros($booksService, $query);
} else {
    echo "Valor de busqueda vacio";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Google OAuth Dashboard</title>
</head>

<body>
    <p>
        <a href="dashboard.php">Regresar al dashboard</a>
    </p>
</body>

</html>