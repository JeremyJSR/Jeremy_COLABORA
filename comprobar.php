<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Inicio de Sesión</title>
</head>
<body>

<?php
if (isset($_POST["usu"]) && isset($_POST["clave"])) {
    $conexion = mysqli_connect("localhost", "root", "", "ejegit");

    if (!$conexion) {
        echo "ERROR: Imposible establecer conexión con la base de datos.<br>\n";
    } else {
        // Sanitizamos los datos de entrada
        $correo = $_POST["usu"];
        $clave = $_POST["clave"];

        // Usamos una consulta preparada para evitar SQL Injection
        $query = "SELECT nombre, apellido, correo FROM usuarios WHERE correo = ? AND contraseña = MD5(?)";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            // Vinculamos los parámetros de entrada a la consulta
            mysqli_stmt_bind_param($stmt, "ss", $correo, $clave);

            // Ejecutamos la consulta
            mysqli_stmt_execute($stmt);

            // Obtenemos el resultado de la consulta
            $resul = mysqli_stmt_get_result($stmt);

            if (!$resul) {
                echo "ERROR: Imposible realizar consulta.<br>\n";
            } else {
                if (mysqli_num_rows($resul) == 0) {
                    echo "<br><b>Usuario y/o clave incorrectos!<br></b>\n";
                } else {
                    // Redirigimos a la página de usuarios
                    header("Location: usuarios.html");
                    exit(); // Asegura que el script se detenga después de redirigir
                }
            }

            // Cerramos la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "ERROR: No se pudo preparar la consulta.<br>\n";
        }

        mysqli_close($conexion);
    }
}
?>

</body>
</html>