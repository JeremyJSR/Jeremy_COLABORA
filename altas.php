<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.9;
        }
        .btn-volver {
            display: inline-block;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-volver:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Usuario</h1>
        <form action="altas.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Registrar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conexión a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "ejegit");

            if (!$conexion) {
                die("ERROR: No se pudo conectar a la base de datos.<br>\n");
            }

            // Datos del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $contraseña = $_POST['contraseña'];

            // Consulta preparada para evitar inyecciones SQL
            $query = "INSERT INTO usuarios (nombre, apellido, correo, contraseña) VALUES (?, ?, ?, MD5(?))";

            if ($stmt = mysqli_prepare($conexion, $query)) {
                // Vinculamos los parámetros a la consulta
                mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellido, $correo, $contraseña);

                // Ejecutamos la consulta
                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>¡Usuario registrado exitosamente!</p>";
                } else {
                    echo "<p>Error al registrar el usuario: " . mysqli_error($conexion) . "</p>";
                }

                // Cerramos la declaración
                mysqli_stmt_close($stmt);
            } else {
                echo "ERROR: No se pudo preparar la consulta.<br>\n";
            }

            // Cerramos la conexión
            mysqli_close($conexion);
        }
        ?>
        <a href="index.html" class="btn-volver">Volver</a>
    </div>
</body>
</html>