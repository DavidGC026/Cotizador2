<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

if (!$_POST['costoTotal'], $_POST['datosTabla'])) {
    die("Faltan datos necesarios.");
}

$usuariopr = $_POST['usuariopr'];
$usuario = $_POST['usuario'];
$costoTotal = $_POST['costoTotal'];
$libros_seleccionados_json = $_POST['datosTabla'];
$libros_seleccionados = json_decode($libros_seleccionados_json, true);

$cliente_servername = "localhost";
$cliente_username = "admin";
$cliente_password = "Imc590923cz4#";
$cliente_dbname = "mysql";
$conn_cliente = new mysqli($cliente_servername, $cliente_username, $cliente_password, $cliente_dbname);

if ($conn_cliente->connect_error) {
    die("La conexión a la base de datos del cliente falló: " . $conn_cliente->connect_error);
}

$sql_cliente = "SELECT id, nombre, apellido_p, apellido_m, empresa, puesto, contacto, correo FROM clientes WHERE usuario = ?";
$stmt_cliente = $conn_cliente->prepare($sql_cliente);
$stmt_cliente->bind_param("s", $usuario);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();

$cliente_data = $result_cliente->fetch_assoc();


$sql_usuario = "SELECT nombre, laboratorio FROM usuarios WHERE usuariopr = ?";
$stmt_usuario = $conn_cliente->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $usuariopr);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$row_usuario = $result_usuario->fetch_assoc();
$nombre_usuario = $row_usuario['nombre'];

$conn_cliente->close();

$cliente_nombre = $cliente_data['nombre'] . ' ' . $cliente_data['apellido_p'] . ' ' . $cliente_data['apellido_m'];
$cliente_puesto = $cliente_data['puesto'];
$cliente_empresa = $cliente_data['empresa'];
$cliente_contacto = $cliente_data['contacto'];
$cliente_correo = $cliente_data['correo'];
$cliente_nombre1 = $cliente_data['nombre'];

$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "librosimcyc";
$conn1 = new mysqli($servername, $username, $password, $dbname);

if ($conn1->connect_error) {
    die("La conexión a la base de datos principal falló: " . $conn1->connect_error);
}

$folio = $cliente_nombre1 . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
    
$sql_last_id = "SELECT id FROM cotizaciones ORDER BY id DESC LIMIT 1";
$result_last_id = $conn1->query($sql_last_id);

if ($result_last_id->num_rows > 0) {
    $row = $result_last_id->fetch_assoc();
    $last_id = $row["id"];
    $next_id = $last_id + 1;
    $folio1 = "COT-GT-" . str_pad($next_id, 4, "0", STR_PAD_LEFT);
} else {
    $folio1 = "COT-GT-0001";
}

$conn1->close();

// Creamos el objeto TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Cotizacion');
$pdf->SetAuthor('IMCYC');
$pdf->SetTitle('Cotizacion');
$pdf->SetSubject('Cotizador');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, '', 0, 1);
$meses = array(
    "January" => "enero",
    "February" => "febrero",
    "March" => "marzo",
    "April" => "abril",
    "May" => "mayo",
    "June" => "junio",
    "July" => "julio",
    "August" => "agosto",
    "September" => "septiembre",
    "October" => "octubre",
    "November" => "noviembre",
    "December" => "diciembre"
);

$fechaActual = date('d \d\e F \d\e Y');
foreach ($meses as $mesIngles => $mesEspanol) {
    $fechaActual = str_replace($mesIngles, $mesEspanol, $fechaActual);
}

$yearac = date("Y");
$numCotizacion = $folio1.'-'.$yearac;
$pdf->Cell(0, 4, "Ciudad de México, a $fechaActual", 0, 1, 'R');
$pdf->Cell(0, 4, "$numCotizacion", 0, 1, 'R');
$pdf->Cell(0, 4, $cliente_nombre, 0, 1);
$pdf->Cell(0, 4, $cliente_puesto, 0, 1);
$pdf->Cell(0, 4, $cliente_empresa, 0, 1);
$pdf->Cell(0, 4, $cliente_contacto, 0, 1);
$pdf->Cell(0, 4, $cliente_correo, 0, 1);
$pdf->Cell(0, 4, "Referencia: 'Cotizacion de Libros'", 0, 1, 'R');
$pdf->Ln();
$pdf->SetFont('helvetica','B',10);
$pdf->SetFont('helvetica', '', 10);
$html .= '<p><strong>Costo Total:</strong> $' . htmlspecialchars($costoTotal) . '</p>';

$html .= '<table border="1">';
$html .= '<tr><th>Título</th><th>Autor</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>';

foreach ($libros_seleccionados as $fila) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($fila['titulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['autor']) . '</td>';
    $html .= '<td>$' . htmlspecialchars($fila['precio']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['cantidad']) . '</td>';
    $html .= '<td>$' . htmlspecialchars($fila['total']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$filename = 'cotizacion_libros_' . date('YmdHis') . '.pdf';

$pdf->Output($filename,'I');

$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "librosimcyc";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión a la base de datos principal falló: " . $conn->connect_error);
}

$folio = $cliente_nombre1 . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
    
$sql_last_id = "SELECT id FROM cotizaciones ORDER BY id DESC LIMIT 1";
$result_last_id = $conn->query($sql_last_id);

if ($result_last_id->num_rows > 0) {
    $row = $result_last_id->fetch_assoc();
    $last_id = $row["id"];
    $next_id = $last_id + 1;
    $folio1 = "COT-GT-" . str_pad($next_id, 4, "0", STR_PAD_LEFT);
} else {
    $folio1 = "COT-GT-0001";
}

$yearac = date("Y");
$numCotizacion = $folio1 .'-'.$yearac;

$fecha = date('Y-m-d');
$productos_ids = [];
$cantidades = [];
$ids = [];
foreach ($libros_seleccionados as $fila) {
    $productos_ids[] = $fila['titulo'];
    $cantidades[] = $fila['cantidad'];
    $ids[] = $fila['id'];
}

$productos_ids_str = implode(',', $productos_ids);
$cantidades_str = implode(',', $cantidades);
$ids_str = implode(',',$ids);

$sql_insertar_cotizacionf = "INSERT INTO cotizacionesf (Fecha, id_productos, productos, cantidades, importe, folio_cot) VALUES (?,?,?,?,?,?)";
$stmt_insertar_cotizacionf = $conn->prepare($sql_insertar_cotizacionf);

if ($stmt_insertar_cotizacionf) {
    $ids_str = implode(',', $ids); // Convertir el array de ids a una cadena
    $stmt_insertar_cotizacionf->bind_param("ssssss", $fecha, $ids_str, $productos_ids_str, $cantidades_str, $costoTotal, $folio);
    $stmt_insertar_cotizacionf->execute();
} else {
    echo "Error: " . $conn->error;
}

$stmt_insertar_cotizacionf->close();

foreach ($libros_seleccionados as $fila) {

    $titulo = $fila['titulo'];
    $cantidad = $fila['cantidad'];
    $sql_ventas = "SELECT ventas FROM libros WHERE titulo = ?";
    $stmt_ventas = $conn->prepare($sql_ventas);
    $stmt_ventas->bind_param("s", $titulo);
    $stmt_ventas->execute();
    $result_ventas = $stmt_ventas->get_result();

    if ($result_ventas->num_rows > 0) {
        $ventas_row = $result_ventas->fetch_assoc();
        $ventas_actual = $ventas_row['ventas'];
        if ($ventas_actual == '0') {
            $nuevo_ventas = $cantidad;
        } else {
            $nuevo_ventas = $ventas_actual + $cantidad;
        }
        $sql_actualizar_ventas = "UPDATE libros SET ventas = ? WHERE titulo = ?";
        $stmt_actualizar_ventas = $conn->prepare($sql_actualizar_ventas);
        $stmt_actualizar_ventas->bind_param("ss", $nuevo_ventas, $titulo);
        $stmt_actualizar_ventas->execute();
    }
}

$fecha = date('Y-m-d H:i:s');
$sql_insertar_cotizacion = "INSERT INTO cotizaciones (numCotizacion, folio, cliente, capturo, fecha, usuariocl) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insertar_cotizacion = $conn->prepare($sql_insertar_cotizacion);
$stmt_insertar_cotizacion->bind_param("ssssss", $numCotizacion, $folio, $cliente_nombre, $nombre_usuario, $fecha, $usuario);
$stmt_insertar_cotizacion->execute();

$conn->close();

$pdfFileName = '/var/www/html/cotizador/models/facturasLibros/' . $folio . '.pdf';
$pdf->Output($pdfFileName, 'F');
?>

