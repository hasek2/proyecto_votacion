<?php
$servername = "localhost";    // Servidor de la base de datos, generalmente es localhost
$username = "root";           // Usuario de la base de datos, por defecto es root en XAMPP
$password = "";               // Contraseña del usuario de la base de datos, por defecto es vacío en XAMPP
$dbname = "votaciones"; // Nombre de la base de datos que creaste

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
