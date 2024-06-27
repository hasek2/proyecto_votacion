<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT id, nombre FROM candidatos";
$result = $conn->query($sql);

$candidatos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $candidatos[] = $row;
    }
}

echo json_encode($candidatos);

$conn->close();
?>
