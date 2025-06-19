<?php
// datos_conexion.php
$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "mysql";
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
            background-color: #1e2856;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        #login-container {
            background-color: black;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #ffffff;
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
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            background-color: #1e2856;
            color: white;
            border: 1px solid white;
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
    <a href="https://imcyc.com" id="logo-link">
        <img id="logo" src="models/logo.svg" alt="IMCYC Logo">
   </a>
        <h2>Iniciar Sesión</h2>

        <form action="procesar_login.php" method="post" onsubmit="return validarFormulario()">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>

</body>
</html>

