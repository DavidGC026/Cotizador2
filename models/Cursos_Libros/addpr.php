<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Campos en Tabla</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 600px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Insertar Campos en Tabla</h1>
        <form action="insertar_campos.php" method="POST">
            <div class="form-group">
                <label for="tabla">Selecciona una tabla:</label>
                <select id="tabla" class="form-control" name="tabla" required>
                    <?php
                    // Datos de conexión a la base de datos
                    $servername = "localhost";
                    $username = "admin";
                    $password = "Imc590923cz4#";
                    $dbname = "librosimcyc";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta SQL para obtener las tablas disponibles
                    $sql = "SHOW TABLES";
                    $result = $conn->query($sql);

                    // Mostrar opciones de tabla en el select
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tabla = $row['Tables_in_librosimcyc'];
                            // Excluir tablas específicas
                            if ($tabla != 'cotizaciones' && $tabla != 'cotizacionesf') {
                                echo "<option value='$tabla'>$tabla</option>";
                            }
                        }
                    } else {
                        echo "<option value='' disabled>No hay tablas disponibles</option>";
                    }

                    // Cerrar conexión
                    $conn->close();
                    ?>
                </select>
            </div>
            <input type="submit" class="btn btn-success" value="Continuar">
        </form>
    </div>
</body>
</html>

