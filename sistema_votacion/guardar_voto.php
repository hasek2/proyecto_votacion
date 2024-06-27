<?php
include 'db.php'; // Asegúrate de que db.php contenga la conexión a tu base de datos

// Validar datos
$nombre_apellido = isset($_POST['nombre_apellido']) ? trim($_POST['nombre_apellido']) : '';
$alias = isset($_POST['alias']) ? trim($_POST['alias']) : '';
$rut = isset($_POST['rut']) ? trim($_POST['rut']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$region_id = isset($_POST['region']) ? intval($_POST['region']) : 0;
$comuna_id = isset($_POST['comuna']) ? intval($_POST['comuna']) : 0;
$candidato_id = isset($_POST['candidato']) ? intval($_POST['candidato']) : 0;
$medio_entero = isset($_POST['medio_entero']) ? implode(", ", $_POST['medio_entero']) : '';

// Verificar duplicación de votos por RUT
$stmt = $conn->prepare("SELECT * FROM votos WHERE rut = ?");
$stmt->bind_param("s", $rut);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("Ya se ha registrado un voto con este RUT.");
}
$stmt->close();

// Guardar en la base de datos
$stmt = $conn->prepare("INSERT INTO votos (nombre_apellido, alias, rut, email, region_id, comuna_id, candidato_id, medio_entero) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiiss", $nombre_apellido, $alias, $rut, $email, $region_id, $comuna_id, $candidato_id, $medio_entero);

if ($stmt->execute()) {
    echo "Voto registrado exitosamente.";
} else {
    echo "Error al registrar el voto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
