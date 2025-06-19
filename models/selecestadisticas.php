<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Estadísticas - IMCYC</title>
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
        <h2>Seleccionar Tipo de Estadísticas</h2>

        <form action="" method="get" id="formulario">
            <label for="tipo_estadisticas">Selecciona el tipo de estadísticas:</label>
            <select id="tipo_estadisticas" name="tipo_estadisticas" required>
                <option value="libros">Estadísticas para Libros</option>
                <option value="laboratorio">Estadísticas para Laboratorio</option>
            </select>

            <input type="submit" value="Seleccionar">
        </form>
    </div>
</body>
</html>

<?php
if(isset($_GET['tipo_estadisticas'])) {
    $tipo_estadisticas = $_GET['tipo_estadisticas'];

    if($tipo_estadisticas === 'libros') {
        // Redirigir a la página de estadísticas para libros
        header("Location: estadisticasl/paginaestadisticas.php");
        exit();
    } elseif($tipo_estadisticas === 'laboratorio') {
        // Redirigir a la página de estadísticas para laboratorio
        header("Location: estadisticas/paginaestadisticas.php");
        exit();
    }
}
?>
