<?php

include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Reserva</title>
</head>

<body>
    <form action="index.php" method="POST">
        <label for="">ID DEL CLIENTE:</label>
        <input type="text" name="Id_cliente" id="Id_cliente" placeholder="ID DEL CLIENTE" required><br>
        <label for="">ID DE HABITACION:</label>
        <input type="text" name="Id_hab" id="Id_hab" placeholder="ID DE HABITACION" required><br>
        <label for="">FECHA DE INICIO:</label>
        <input type="date" name="FechaInicio" id="FechaInicio" required><br>
        <label for="">FECHA FINAL:</label>
        <input type="date" name="FechaFin" id="FechaFinal" required><br>
        <input type="submit" value="Registrar" name="btnRegistrar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["Id_cliente"];
        $habitacion = $_POST["Id_hab"];
        $inicio = $_POST["FechaInicio"];
        $final = $_POST["FechaFin"];

        // Preparar la consulta
        $btnRegistrar = $conexion->prepare("INSERT INTO reserva (Id_cliente, Id_hab, FechaInicio, FechaFin) VALUES (?,?,?,?)");
        if ($btnRegistrar === false) {
            $_SESSION['error'] = "Error en la preparación de la consulta: " . $conexion->error;
            header("Location: index.php");
            exit();
        }

        // Vincular los parámetros y ejecutar la consulta
        $btnRegistrar->bind_param("ssss", $id, $habitacion, $inicio, $final);

        if ($btnRegistrar->execute()) {
            $_SESSION['success'] = "Usuario registrado exitosamente";
        } else {
            $_SESSION['error'] = "Error al registrar la reserva: " . $btnRegistrar->error;
        }

        // Cerrar la declaración y la conexión
        $btnRegistrar->close();
        $conexion->close();

        // Redireccionar de vuelta al formulario de registro
        header("Location: index.php");
        exit();
    }
    ?>
</body>

</html>
