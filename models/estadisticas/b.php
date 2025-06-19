<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Ventas</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        /* Estilos CSS para el menú horizontal */
        ul.menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #007bff;
        }
        #graficoPastelMasVendidos {
            max-width: 300px; /* Ajustar el tamaño según sea necesario */
            margin: 0 auto;
        }

        ul.menu li {
            float: left;
        }

        ul.menu li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.menu li a:hover {
            background-color: #0056b3;
        }

        /* Estilos CSS restantes */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1, h2, h3 {
            color: #007bff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        canvas {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql_mas_vendidos = "SELECT * FROM articulos ORDER BY Ventas DESC LIMIT 20";
    $result_mas_vendidos = $conn->query($sql_mas_vendidos);

    $productos_mas_vendidos = [];
    $ventas_mas_vendidos = [];
    while ($row = $result_mas_vendidos->fetch_assoc()) {
        $productos_mas_vendidos[] = $row['Numero_Articulo'];
        $ventas_mas_vendidos[] = $row['ventas'];
    }

    $sql_menos_vendidos = "SELECT * FROM articulos ORDER BY Ventas ASC LIMIT 20";
    $result_menos_vendidos = $conn->query($sql_menos_vendidos);

    $productos_menos_vendidos = [];
    $ventas_menos_vendidos = [];
    while ($row = $result_menos_vendidos->fetch_assoc()) {
        $productos_menos_vendidos[] = $row['Numero_Articulo'];
        $ventas_menos_vendidos[] = $row['ventas'];
    }

    $conn->close();
    ?>

    <!-- Mostrar el gráfico de barras de los productos más vendidos -->
    <h2>Productos más vendidos</h2>
    <canvas id="graficoMasVendidos"></canvas>

    <script>
    // Configurar y dibujar el gráfico de los productos más vendidos
    var ctxMasVendidos = document.getElementById('graficoMasVendidos').getContext('2d');
    var graficoMasVendidos = new Chart(ctxMasVendidos, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($productos_mas_vendidos); ?>,
            datasets: [{
                label: 'Ventas',
                data: <?php echo json_encode($ventas_mas_vendidos); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    
    <h2>Distribución de ventas de productos más vendidos</h2>
<canvas id="graficoPastelMasVendidos"></canvas>

<script>
// Configurar y dibujar el gráfico de pastel de los productos más vendidos
var ctxPastelMasVendidos = document.getElementById('graficoPastelMasVendidos').getContext('2d');
var graficoPastelMasVendidos = new Chart(ctxPastelMasVendidos, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($productos_mas_vendidos); ?>,
        datasets: [{
            label: 'Ventas',
            data: <?php echo json_encode($ventas_mas_vendidos); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


    <!-- Mostrar el gráfico de barras de los productos menos vendidos -->
    <h2>Productos menos vendidos</h2>
    <canvas id="graficoMenosVendidos"></canvas>

    <script>
    // Configurar y dibujar el gráfico de los productos menos vendidos
    var ctxMenosVendidos = document.getElementById('graficoMenosVendidos').getContext('2d');
    var graficoMenosVendidos = new Chart(ctxMenosVendidos, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($productos_menos_vendidos); ?>,
            datasets: [{
                label: 'Ventas',
                data: <?php echo json_encode($ventas_menos_vendidos); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    <!-- Informe -->
<h1>Informe</h1>
<h2>Productos y descripciones: </h2>
<h3>Productos más vendidos</h3>
<table border="1">
    <tr>
        <th>Producto</th>
        <th>Número de Artículo</th>
        <th>Descripción</th>
        <th>Precio de Venta</th>
        <th>Ventas</th>
    </tr>
    <?php
    foreach ($result_mas_vendidos as $row) {
        echo "<tr>";
        echo "<td>" . $row['Producto'] . "</td>";
        echo "<td>" . $row['Numero_Articulo'] . "</td>";
        echo "<td>" . $row['Descripcion'] . "</td>";
        echo "<td>" . $row['Precio_Venta'] . "</td>";
        echo "<td>" . $row['ventas'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h3>Productos menos vendidos</h3>
<table border="1">
    <tr>
        <th>Producto</th>
        <th>Número de Artículo</th>
        <th>Descripción</th>
        <th>Precio de Venta</th>
        <th>Ventas</th>
    </tr>
    <?php
    foreach ($result_menos_vendidos as $row) {
        echo "<tr>";
        echo "<td>" . $row['Producto'] . "</td>";
        echo "<td>" . $row['Numero_Articulo'] . "</td>";
        echo "<td>" . $row['Descripcion'] . "</td>";
        echo "<td>" . $row['Precio_Venta'] . "</td>";
        echo "<td>" . $row['ventas'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>


</body>
</html>
