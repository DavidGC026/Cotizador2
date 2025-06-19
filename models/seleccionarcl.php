<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #00489e;
            text-align: center;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #00489e;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select:hover {
            background-color: #f2f2f2;
        }

        option {
            background-color: #ffffff;
            color: #00489e;
        }

        option:hover {
            background-color: #f2f2f2;
        }

        input[type="submit"] {
            background-color: #00489e;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 10px auto;
        }

        input[type="submit"]:hover {
            background-color: #003366;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Seleccionar Cliente</h1>
        <form action="modificar_cliente.php" method="post">
            <div class="form-group">
                <label for="cliente">Seleccione un cliente:</label>
                <select name="cliente" id="cliente" class="form-control">
                    <?php
                    $servername = "localhost";
                    $username = "admin";
                    $password = "Imc590923cz4#";
                    $dbname = "mysql";

                    $conexion = new mysqli($servername, $username, $password, $dbname);
                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }

                    $sql = "SELECT id, nombre, apellido_p FROM clientes";
                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . " " . $row['apellido_p'] . "</option>";
                    }

                    // Cerrar conexión
                    $conexion->close();
                    ?>
                </select>
            </div>
            <input type="submit" value="Seleccionar" class="btn btn-primary btn-block">
        </form>
    </div>
</body>
</html>

