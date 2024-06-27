<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT id, nombre FROM regiones";
$result = $conn->query($sql);

$regiones = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $regiones[] = $row;
    }
}

echo json_encode($regiones);

$conn->close();
?>
