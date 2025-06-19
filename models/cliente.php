<?php
$usuariopr = $_GET['usuariopr'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - IMCYC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #login-container {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            font-size: 28px;
        }

        #logo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555555;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #registro-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div id="login-container">
        <img id="logo" src="logo.svg" alt="IMCYC Logo">
        <h2>Consultar Cotizacion</h2>

        <form action="obtener_cliente.php" method="post" id="formulario">
            <input type="hidden" name="usuariopr" value="<?php echo htmlspecialchars($usuariopr); ?>">
            <label for="usuario">Cliente:</label>
            <select id="usuario" name="usuario" required>
                <?php
                $servername = "localhost";
                $username = "admin";
                $password = "Imc590923cz4#";
                $dbname = "mysql";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                $sql = "SELECT id, nombre, usuario FROM clientes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["usuario"]."'>".$row["nombre"]."</option>";
                    }
                } else {
                    echo "<option value=''>No hay usuarios</option>";
                }
                $conn->close();
                ?>
            </select>

            <input type="submit" value="Buscar Cliente">
        </form>
    </div>
</body>
</html>

