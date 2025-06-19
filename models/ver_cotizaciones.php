<?php
// datos_conexion.php
$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "mysql";

$tipo_cotizacion = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$dbname = "mysql";
$ruta_descarga = "archivos";

if ($tipo_cotizacion === 'libros') {
    $dbname = "librosimcyc";
    $ruta_descarga = "facturasLibros";
} elseif ($tipo_cotizacion === 'laboratorio') {
    $dbname = "mysql";
    $ruta_descarga = "archivos";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$sql_cotizaciones = "SELECT * FROM cotizaciones";

$result_cotizaciones = $conn->query($sql_cotizaciones);

if ($result_cotizaciones->num_rows > 0) {
    while ($row = $result_cotizaciones->fetch_assoc()) {
        $cotizaciones[] = $row;
    }
} else {
    $cotizaciones = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cotizaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            color: #001f3f;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #001f3f;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ddd;
        }

        .btn-group .btn {
            transition: background-color 0.3s ease-in-out;
        }

        .btn-group .btn.active {
            background-color: #007bff;
        }

        .descargar-btn {
            background-color: #001f3f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .descargar-btn:hover {
            background-color: #003366;
        }

        .enviar-btn {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .enviar-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Ver Cotizaciones</h2>

        <div class="row">
            <div class="col">
                <div class="btn-group" role="group" aria-label="Tipos de Cotización">
                    <button type="button" class="btn btn-primary <?php if ($tipo_cotizacion === 'libros') echo 'active'; ?>"><a href="?tipo=libros" style="color: white; text-decoration: none;">Libros</a></button>
                    <button type="button" class="btn btn-primary <?php if ($tipo_cotizacion === 'laboratorio') echo 'active'; ?>"><a href="?tipo=laboratorio" style="color: white; text-decoration: none;">Laboratorio</a></button>
                </div>
            </div>
        </div>

        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Folio</th>
                    <th>#Cotizacion</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Capturo</th>
                    <th>Descargar</th>
                    <th>Enviar por Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cotizaciones as $cotizacion) {
                    echo "<tr>";
                    echo "<td>{$cotizacion['id']}</td>";
                    echo "<td>{$cotizacion['folio']}</td>";
                    echo "<td>{$cotizacion['numCotizacion']}</td>";
                    echo "<td>{$cotizacion['cliente']}</td>";
                    echo "<td>{$cotizacion['fecha']}</td>";
                    echo "<td>{$cotizacion['capturo']}</td>";
                    echo "<td><a href=\"http://grabador.imcyc.com/cotizador/models/$ruta_descarga/{$cotizacion['folio']}.pdf\" class='btn btn-primary descargar-btn'>Ver Cotizacion</a></td>";
                    echo "<td><a href=\"";
                    if ($tipo_cotizacion === 'libros') {
                        echo "enviarcolibros.php";
                    } else {
                        echo "enviar_correo.php";
                    }
                    echo "?folio={$cotizacion['folio']}&usuario={$cotizacion['usuariocl']}\" class='btn btn-success enviar-btn'>Enviar por Correo</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

