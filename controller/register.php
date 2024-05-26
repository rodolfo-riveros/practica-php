<?php
require_once "../conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    if ($stmt === false) {
        $_SESSION['error'] = "Error en la preparación de la consulta: " . $conn->error;
        header("Location: /view/register.php");
        exit();
    }

    $stmt->bind_param("ss", $email, $hashed_password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['success'] = "Usuario registrado exitosamente";
    } else {
        $_SESSION['error'] = "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
    // Cerrar la conexión
    $conn->close();

    // Redireccionar de vuelta al formulario de registro
    header("Location: /view/register.php");
    exit();
}
?>