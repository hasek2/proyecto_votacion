<?php
include 'db.php';

header('Content-Type: application/json');

$region_id = intval($_GET['region_id']);

$sql = "SELECT id, nombre FROM comunas WHERE region_id = $region_id";
$result = $conn->query($sql);

$comunas = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $comunas[] = $row;
    }
}

echo json_encode($comunas);

$conn->close();
?>
