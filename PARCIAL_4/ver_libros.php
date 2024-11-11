<?php
require_once "config_mysqli.php";
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM libros_guardados WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql_delete)) {
        mysqli_stmt_bind_param($stmt, "i", $delete_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record deleted successfully.";
        } else {
            echo "ERROR: Could not execute $sql_delete. " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
$sql = "SELECT * FROM libros_guardados";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("ERROR: Could not execute query: $sql. " . mysqli_error($conn));
}
echo "<table border='1'>";
echo "<tr><th>Book Title</th><th>Author</th><th>Review</th><th>Saved On</th><th>Action</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
    echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['reseña_personal']) . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha_guardado']) . "</td>";
    echo "<td><a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>

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