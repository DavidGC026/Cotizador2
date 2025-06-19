<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../cliente2.php");
    exit();
    }

$usuario = $_SESSION['usuario'];
$usuario1 = $usuario;


$usuariopr = $_GET['usuariopr'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tabla</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            text-align: center;
        }
        .form-group {
            margin-bottom: 30px;
        }
        label {
            color: #495057;
            font-weight: bold;
        }
        select.form-control {
            border-color: #ced4da;
            color: #495057;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Seleccionar Tabla</h2>
        <form action="mostrar_datos2.php" method="get"> 
            <input type="hidden" name="usuariocl" value="<?php echo $usuario ?>">
            <input type="hidden" name="usuariopr" value="<?php echo $usuariopr ?>">
            <div class="form-group">
                <label for="tabla">Seleccione una tabla: <?php echo $usuario1 ?></label>
                <select class="form-control" name="tabla" id="tabla">
                    <?php
                    $servername = "localhost";
                    $username = "admin";
                    $password = "Imc590923cz4#";
                    $dbname = "librosimcyc";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta para obtener las tablas disponibles excepto las mencionadas
                    $tables_query = "SHOW TABLES FROM $dbname WHERE `Tables_in_$dbname` NOT IN ('cotizaciones', 'cotizacionesf', 'libros', 'cursos')";
                    $tables_result = $conn->query($tables_query);

                    if ($tables_result->num_rows > 0) {
                        while($table_row = $tables_result->fetch_row()) {
                            echo "<option value='{$table_row[0]}'>{$table_row[0]}</option>";
                        }
                    } else {
                        echo "<option disabled selected>No hay tablas disponibles</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mostrar Datos</button>
        </form>
    </div>
</body>
</html>

