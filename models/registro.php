<?php
// datos_conexion.php
$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "mysql";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

function generarUsuario($nombre, $conn) {
    $nombreUsuario = strtolower(str_replace(' ', '', $nombre));
    $sql = "SELECT * FROM clientes WHERE usuario = '$nombreUsuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 1;
        while ($result->num_rows > 0) {
            $nombreUsuario = $nombreUsuario . $i;
            $sql = "SELECT * FROM clientes WHERE usuario = '$nombreUsuario'";
            $result = $conn->query($sql);
            $i++;
        }
    }
    return $nombreUsuario;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido_p = $_POST["apellido_p"];
    $apellido_m = $_POST["apellido_m"];
    $empresa = $_POST["empresa"];
    $puesto = $_POST["puesto"];
    $correo = $_POST["correo"];
    $contacto = $_POST["contacto"];

    $usuario = generarUsuario($nombre, $conn);

    $sql = "INSERT INTO clientes (nombre, apellido_p, apellido_m, empresa, puesto, usuario, correo, contacto)
    VALUES ('$nombre', '$apellido_p', '$apellido_m', '$empresa', '$puesto', '$usuario', '$correo', '$contacto')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - IMCYC</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            justify-content: center;
            padding: 20px;
        }

        #registro-container {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #ffffff;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #login-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="registro-container">
                    <h2>Registro de Cliente</h2>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>

                        <label for="apellido_p">Apellido Paterno:</label>
                        <input type="text" id="apellido_p" name="apellido_p" class="form-control" required>

                        <label for="apellido_m">Apellido Materno:</label>
                        <input type="text" id="apellido_m" name="apellido_m" class="form-control" required>

                        <label for="empresa">Empresa:</label>
                        <input type="text" id="empresa" name="empresa" class="form-control" required>

                        <label for="puestp">Puesto:</label>
                        <input type="text" id="puesto" name="puesto" class="form-control" required>

                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" class="form-control" required>

                        <label for="contacto">Telefono:</label>
                        <input type="text" id="contacto" name="contacto" class="form-control" required>

                        <input type="submit" value="Registrar" class="btn btn-primary btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

