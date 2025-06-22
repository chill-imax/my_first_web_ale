<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si el formulario ha sido enviado usando el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanear los datos para prevenir ataques de inyección SQL, usando real_escape_string
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $email = $conn->real_escape_string($_POST['email']);
    $mensaje = $conn->real_escape_string($_POST['mensaje']);

    // Crear la consulta SQL para insertar los datos del formulario en la tabla 'clientes'
    $sql = "INSERT INTO clientes (nombre, telefono, correo, mensaje) 
            VALUES ('$nombre', '$telefono', '$email', '$mensaje')";

    // Ejecutar la consulta SQL y verificar si la inserción fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Si la inserción fue exitosa, se envía el correo y se muestra un mensaje de éxito
        echo "success";
        // Incluir el archivo 'correo.php' para enviar los correos (notificación al cliente y al administrador)
        include 'correo.php';
    } else {
        // Si hubo un error en la inserción, mostrar un mensaje de error
        echo "error";
    }

    // Cerrar la conexión con la base de datos
    $conn->close();
} else {
    // Si no se han recibido datos del formulario, retornar un mensaje en formato JSON
    echo json_encode(["success" => false, "message" => "No se han recibido datos."]);
}
?>
