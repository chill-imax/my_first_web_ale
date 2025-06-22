<?php
// Importa las clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Requiere el autoload de Composer para cargar las dependencias
require 'vendor/autoload.php';

// Conectar a la base de datos
$mysqli = new mysqli("sql313.infinityfree.com", "if0_38239515", "F4gHwMI9yWE", "if0_38239515_contactos");

// Verificar conexión
if ($mysqli->connect_error) {
    // Si la conexión falla, muestra el error y termina la ejecución del script
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener el último cliente registrado desde la base de datos
$result = $mysqli->query("SELECT correo, nombre, telefono, mensaje FROM clientes ORDER BY id DESC LIMIT 1");

// Si hay resultados, procesamos el primer registro
if ($result->num_rows > 0) {
    // Obtiene los datos del cliente (correo, nombre, teléfono y mensaje)
    $row = $result->fetch_assoc();
    $email = $row['correo'];
    $nombre = $row['nombre'];
    $telefono = $row['telefono'];
    $mensaje = $row['mensaje'];

    // Crear una nueva instancia de PHPMailer para enviar correos
    $mail = new PHPMailer(true);
    try {
        // Configurar PHPMailer para usar SMTP
        $mail->isSMTP();  // Usar SMTP para el envío
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;  // Activar autenticación SMTP
        $mail->Username = '1509.wonder@gmail.com';  // Usuario de Gmail
        $mail->Password = 'qpfy ltzy nhjn mjwx';  // Contraseña de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Cifrado de seguridad STARTTLS
        $mail->Port = 587;  // Puerto para la conexión SMTP

        // Establecer el remitente y el destinatario del correo
        $mail->setFrom('tucorreo@gmail.com', 'Ale Brito');  // Remitente
        $mail->addAddress($email, $nombre);  // Destinatario: correo del cliente

        // Configurar el contenido del correo
        $mail->isHTML(true);  // El cuerpo del correo será HTML
        $mail->Subject = 'Gracias por comunicarte con Ale Brito';  // Asunto del correo
        $mail->Body = "<h3>¡Hola $nombre!</h3><p>Gracias por escribirnos, en breve atenderemos tu mensaje.</p>";  // Cuerpo del correo (HTML)

        // Enviar el correo al cliente
        $mail->send();

        // Enviar una notificación al administrador con los detalles del mensaje
        $mail->clearAddresses();  // Limpiar las direcciones previas
        $mail->addAddress('1509.wonder@gmail.com');  // Dirección del administrador

        // Configurar el correo para el administrador
        $mail->Subject = 'Nuevo Mensaje de Contacto';  // Asunto del correo para el administrador
        $mail->Body = "<h3>Nuevo mensaje recibido</h3>
                    <p><b>Nombre:</b> $nombre</p>
                    <p><b>Teléfono:</b> $telefono</p>
                    <p><b>Email:</b> $email</p>
                    <p><b>Mensaje:</b> $mensaje</p>";  // Detalles del mensaje recibido

        // Enviar el correo al administrador
        $mail->send();

        // Mostrar un mensaje de éxito si todo se envió correctamente
        echo "Correos enviados correctamente";
    } catch (Exception $e) {
        // Si ocurre un error al enviar los correos, mostrar el mensaje de error
        echo "Error al enviar los correos: {$mail->ErrorInfo}";
    }
} else {
    // Si no hay registros en la base de datos, mostrar un mensaje
    echo "No hay clientes registrados con email.";
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
