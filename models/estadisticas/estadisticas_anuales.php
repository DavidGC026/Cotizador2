<?php
$conn = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las ventas del mes limitadas a 20 resultados y ordenadas por cantidades de mayor a menor
$sql_ventas_mes = "SELECT id_productos, productos, cantidades FROM cotizacionesf WHERE Fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR) ORDER BY cantidades DESC LIMIT 20";
$result_ventas_mes = $conn->query($sql_ventas_mes);

$ventas_productos = [];

while ($row = $result_ventas_mes->fetch_assoc()) {
    $id_productos = explode(",", $row['id_productos']);
    $productos = explode(",", $row['productos']);
    $cantidades = explode(",", $row['cantidades']);

    for ($i = 0; $i < count($productos); $i++) {
        $producto = trim($productos[$i]);
        $cantidad = (int) trim($cantidades[$i]);
        $id_producto = trim($id_productos[$i]);

        $nombre_producto = $producto . " (ID: " . $id_producto . ")";

        if (isset($ventas_productos[$nombre_producto])) {
            $ventas_productos[$nombre_producto] += $cantidad;
        } else {
            $ventas_productos[$nombre_producto] = $cantidad;
        }
    }
}

// Ordenar el arreglo de ventas de productos por cantidades de mayor a menor
arsort($ventas_productos);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Cotizaciones Anuales</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <!-- Agregando Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1, h2 {
            text-align: center;
        }

        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Estadísticas de Cotizaciones Anuales</h1>

        <!-- Tarjeta para el gráfico de ventas mensuales -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Gráfico de Cotizaciones Anuales</h2>
                <canvas id="graficoVentasMes"></canvas>
            </div>
        </div>

        <!-- Tarjeta para la tabla de top de artículos -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Top Artículos</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Número de Artículo</th>
                                <th>Descripción</th>
                                <th>ONNCCE</th>
                                <th>Precio de Venta</th>
                                <th>Clase</th>
                                <th>Ventas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");
                            if ($conn->connect_error) {
                                die("Error de conexión: " . $conn->connect_error);
                            }

                            $id_productos_all = [];

                            // Consulta para obtener detalles de los artículos limitados a 20 resultados y ordenados por ventas de mayor a menor
                            $sql_id_productos_all = "SELECT id_productos FROM cotizacionesf WHERE Fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR) ORDER BY cantidades DESC LIMIT 20";
                            $result_id_productos_all = $conn->query($sql_id_productos_all);

                            while ($row = $result_id_productos_all->fetch_assoc()) {
                                $id_productos = explode(",", $row['id_productos']);

                                $id_productos_all = array_merge($id_productos_all, $id_productos);
                            }

                            $id_productos_all = array_unique($id_productos_all);
                            ?>
                            <?php foreach ($id_productos_all as $id_producto): ?>
                                <?php
                                $sql_articulo = "SELECT * FROM articulos WHERE id = $id_producto";
                                $result_articulo = $conn->query($sql_articulo);

                                while ($row = $result_articulo->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['Numero_Articulo'] . "</td>";
                                    echo "<td>" . $row['Descripcion'] . "</td>";
                                    echo "<td>" . $row['ONNCCE'] . "</td>";
                                    echo "<td>" . $row['Precio_Venta'] . "</td>";
                                    echo "<td>" . $row['clase'] . "</td>";
                                    echo "<td>" . $row['ventas'] . "</td>";
                                    echo "</tr>";
                                }
                            endforeach;
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    var datos = {
        labels: <?php echo json_encode(array_keys($ventas_productos)); ?>,
        datasets: [{
            label: 'Cantidad Vendida',
            data: <?php echo json_encode(array_values($ventas_productos)); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    var ctx = document.getElementById('graficoVentasMes').getContext('2d');

    var grafico = new Chart(ctx, {
        type: 'bar',
        data: datos,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>

