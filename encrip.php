<?php
// Clave secreta para la encriptación
$clave_secreta = "mi_clave_super_secreta"; // Cámbiala por una más segura

// Función para encriptar una URL
function encriptar_url($url, $clave_secreta) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $url_encriptada = openssl_encrypt($url, 'aes-256-cbc', $clave_secreta, 0, $iv);
    return base64_encode($url_encriptada . '::' . $iv);
}

// Función para desencriptar una URL
function desencriptar_url($url_encriptada, $clave_secreta) {
    $decoded = base64_decode($url_encriptada);
    if (strpos($decoded, '::') === false) {
        die("Error: Formato de encriptación incorrecto");
    }
    list($url_encriptada, $iv) = explode('::', $decoded, 2);
    return openssl_decrypt($url_encriptada, 'aes-256-cbc', $clave_secreta, 0, $iv);
}

// Prueba con una URL sin parámetros
$url_original = "http://localhost/mi_pagina.php";
$url_encriptada = encriptar_url($url_original, $clave_secreta);
echo "URL encriptada: " . $url_encriptada . "<br>";

$url_desencriptada = desencriptar_url($url_encriptada, $clave_secreta);
echo "URL desencriptada: " . $url_desencriptada;
?>
