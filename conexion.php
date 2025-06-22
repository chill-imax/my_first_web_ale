<?php
$servername = "sql313.infinityfree.com"; 
$username = "if0_38239515"; 
$password = "F4gHwMI9yWE"; 
$dbname = "if0_38239515_contactos"; 

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
