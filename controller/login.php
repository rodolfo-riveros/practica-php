<?php
require_once "../conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $password = $_POST["password"];

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
    if ($stmt === false) {
        $_SESSION['error'] = "Error en la preparación de la consulta: " . $conn->error;
        header("Location: /view/login.php");
        exit();
    }

    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /view/panel.php");
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();

    header("Location: /view/login.php");
    exit();
}
?>