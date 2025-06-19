<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
// Conexión a la base de datos
$conn = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los productos más vendidos
$sql_mas_vendidos = "SELECT * FROM articulos WHERE Ventas != 0 ORDER BY Ventas DESC LIMIT 20";
$result_mas_vendidos = $conn->query($sql_mas_vendidos);

// Consulta para obtener los productos menos vendidos
$sql_menos_vendidos = "SELECT * FROM articulos WHERE Ventas != 0 ORDER BY Ventas ASC LIMIT 20";
$result_menos_vendidos = $conn->query($sql_menos_vendidos);

// Crear arrays para almacenar los datos de la gráfica
$productos_mas_vendidos = [];
$ventas_mas_vendidos = [];
$productos_menos_vendidos = [];
$ventas_menos_vendidos = [];

// Llenar los arrays con los datos de la base de datos
while ($fila = $result_mas_vendidos->fetch_assoc()) {
    $productos_mas_vendidos[] = $fila['Producto'];
    $ventas_mas_vendidos[] = $fila['Ventas'];
}

while ($fila = $result_menos_vendidos->fetch_assoc()) {
    $productos_menos_vendidos[] = $fila['Producto'];
    $ventas_menos_vendidos[] = $fila['Ventas'];
}

// Cerrar la conexión
$conn->close();

// Crear instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Informe de Estadísticas de Ventas');
$pdf->SetSubject('Informe de Estadísticas de Ventas');
$pdf->SetKeywords('ventas, estadísticas, informe');

// Agregar una página
$pdf->AddPage();

// Agregar título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Informe de Estadísticas de Ventas', 0, 1, 'C');

// Inicializar variable para almacenar HTML de la tabla
$html = '';

// Agregar tabla de productos más vendidos
$html .= '<h2>Productos más vendidos</h2>';
$html .= '<table border="1" style="font-size: 10px;">';
$html .= '<tr><th>Producto</th><th>Número de Artículo</th><th>Descripción</th><th>Precio de Venta</th><th>Ventas</th></tr>';

foreach ($result_mas_vendidos as $fila) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($fila['Producto']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['Numero_Articulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['Descripcion']) . '</td>';
    $html .= '<td>$' . htmlspecialchars($fila['Precio_Venta']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['ventas']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Agregar tabla de productos menos vendidos
$html .= '<h2>Productos menos vendidos</h2>';
$html .= '<table border="1" style="font-size: 10px;">';
$html .= '<tr><th>Producto</th><th>Número de Artículo</th><th>Descripción</th><th>Precio de Venta</th><th>Ventas</th></tr>';

foreach ($result_menos_vendidos as $fila) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($fila['Producto']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['Numero_Articulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['Descripcion']) . '</td>';
    $html .= '<td>$' . htmlspecialchars($fila['Precio_Venta']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['ventas']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Escribir HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Generar la gráfica en una imagen temporal
$canvas = '<canvas id="tempCanvas" style="display: none;"></canvas>';
$canvas .= '<script>
            var productos_mas_vendidos = ' . json_encode($productos_mas_vendidos) . ';
            var ventas_mas_vendidos = ' . json_encode($ventas_mas_vendidos) . ';
            var productos_menos_vendidos = ' . json_encode($productos_menos_vendidos) . ';
            var ventas_menos_vendidos = ' . json_encode($ventas_menos_vendidos) . ';

            var ctxMasVendidos = document.createElement("canvas").getContext("2d");
            var ctxMenosVendidos = document.createElement("canvas").getContext("2d");

            new Chart(ctxMasVendidos, {
                type: "bar",
                data: {
                    labels: productos_mas_vendidos,
                    datasets: [{
                        label: "Ventas",
                        data: ventas_mas_vendidos,
                        backgroundColor: "rgba(54, 162, 235, 0.5)",
                        borderColor: "rgba(54, 162, 235, 1)",
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

            new Chart(ctxMenosVendidos, {
                type: "bar",
                data: {
                    labels: productos_menos_vendidos,
                    datasets: [{
                        label: "Ventas",
                        data: ventas_menos_vendidos,
                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                        borderColor: "rgba(255, 99, 132, 1)",
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

            var tempCanvasMasVendidos = ctxMasVendidos.canvas;
            var tempCanvasMenosVendidos = ctxMenosVendidos.canvas;

            var tempCanvasMasVendidosImg = tempCanvasMasVendidos.toDataURL();
            var tempCanvasMenosVendidosImg = tempCanvasMenosVendidos.toDataURL();

            document.getElementById("tempCanvas").remove();
        </script>';

$pdf->writeHTML($canvas, true, false, true, false, '');

// Añadir la imagen al PDF
$pdf->Image('@' . $tempCanvasMasVendidosImg, 10, 100, 180, 100);
$pdf->Image('@' . $tempCanvasMenosVendidosImg, 10, 200, 180, 100);

// Salida del PDF
$pdf->Output('Informe_ventas.pdf', 'I');
?>

