<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
        <h1>Modificar Cliente</h1>
        <?php

        $servername = "localhost";
        $username = "admin";
        $password = "Imc590923cz4#";
        $dbname = "mysql";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_cliente = $_POST['cliente'];

            $conexion = new mysqli($servername, $username, $password, $dbname);

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT * FROM clientes WHERE id = $id_cliente";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form action="guardar_modificacion.php" method="post">
                    <input type="hidden" name="id_cliente" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="apellido_p">Apellido Paterno:</label>
                        <input type="text" name="apellido_p" value="<?php echo $row['apellido_p']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="apellido_m">Apellido Materno:</label>
                        <input type="text" name="apellido_m" value="<?php echo $row['apellido_m']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa:</label>
                        <input type="text" name="empresa" value="<?php echo $row['empresa']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto:</label>
                        <input type="text" name="puesto" value="<?php echo $row['puesto']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="text" name="correo" value="<?php echo $row['correo']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="contacto">Telefono:</label>
                        <input type="text" name="contacto" value="<?php echo $row['contacto']; ?>" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Cambios" class="btn btn-primary btn-block">
                </form>
                <?php
            } else {
                echo "Cliente no encontrado.";
            }

            $conexion->close();
        } else {
            echo "Acceso no autorizado.";
        }
        ?>
    </div>
</body>
</html>

