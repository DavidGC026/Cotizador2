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
        .form-group {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Insertar Campos en Tabla</h1>
        <?php
        $servername = "localhost";
        $username = "admin";
        $password = "Imc590923cz4#";
        $dbname = "librosimcyc";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $tabla = $_POST['tabla'];

        if (!empty($tabla)) {
            echo "<h2 class='mt-4'>Insertar Campos en la tabla: $tabla</h2>";
            $sql = "DESCRIBE $tabla";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<form action='insertar_registros.php' method='POST'>";
                echo "<input type='hidden' name='tabla' value='$tabla'>";
                while ($row = $result->fetch_assoc()) {
                    // Excluir los campos 'id' y 'ventas'
                    if ($row['Field'] != 'id' && $row['Field'] != 'ventas') {
                        echo "<div class='form-group'>";
                        echo "<label for='" . $row['Field'] . "'>" . $row['Field'] . "</label>";
                        echo "<input type='text' class='form-control' name='" . $row['Field'] . "' required>";
                        echo "</div>";
                    }
                }
                echo "<input type='submit' class='btn btn-success' value='Insertar'>";
                echo "</form>";
            } else {
                echo "<p>No se encontró la estructura de la tabla.</p>";
            }
        } else {
            echo "<p>No se seleccionó ninguna tabla.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

