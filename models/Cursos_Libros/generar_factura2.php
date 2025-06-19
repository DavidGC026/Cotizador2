<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

if (!isset($_POST['datosTabla'], $_POST['usuariopr'])) {
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
$laboratorio_us = $row_usuario['laboratorio'];

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


class MYPDF extends TCPDF {

    public function Header() {
        $this->SetY(10);
        $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
        $this->Line(10, $this->GetY() + 15, $this->getPageWidth() - 10, $this->GetY() + 15);

        $this->Image('logoimcyc.jpg', 155, 3, 30, 18, 'JPG', 'http://www.imcyc.com', '', true, 150, '', false, false, 0, false, false, false);

        $this->SetTextColor(0, 51, 153);
        $this->SetFont('helvetica', 'B', 10);
        
        $this->Cell(0, 50, 'INSTITUTO MEXICANO DEL CEMENTO Y DEL CONCRETO, A.C', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() { 

        $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
        $this->Line(10, $this->getY() - 20, $this->getPageWidth() - 10, $this->getY() - 20);

        $this->SetY(-25);
        // Set font
        $this->SetTextColor(0, 51, 153);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Insurgentes Sur 1846, Col. Florida, C.P. 01030, CDMX ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln();
        $this->Cell(0, 10, ' Tel. 55 53225742', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('Cotizacion');
$pdf->SetAuthor('IMCYC');
$pdf->SetTitle('Cotizacion');
$pdf->SetSubject('Cotizador');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

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
$pdf->Ln();
$pdf->SetFont('helvetica','B',10);
$pdf->SetFont('helvetica', '', 10);

$conn = new mysqli($servername, $username, $password, $dbname);

$nombre_productos = array();

foreach ($libros_seleccionados as $curso) {
    $curso = $curso['nombre'];
    $sql_producto = "SELECT nombre FROM cursos WHERE nombre = ?";
    $stmt_producto = $conn->prepare($sql_producto);
    $stmt_producto->bind_param("s", $curso);
    $stmt_producto->execute();
    $result_producto = $stmt_producto->get_result();
    $row_producto = $result_producto->fetch_assoc();
    $nombre_producto = $row_producto['nombre'];

    $nombre_productos[] = $nombre_producto;
}

if (count($nombre_productos) === 1) {
    $mensaje = "Agradecemos de antemano la confianza depositada en el IMCYC para desarrollar la presente cotización respecto al cursos $nombre_productos[0]).";
} else {
    $productos_texto = implode(', ', $nombre_productos);
    $mensaje = "Agradecemos de antemano la confianza depositada en el IMCYC para desarrollar la presente cotización respecto a los cursos $productos_texto.";
}

$pdf->MultiCell(0, 10, $mensaje, 0, 'L');
$pdf->Ln();

$pdf->SetFont('helvetica','B',10);
$pdf->SetFont('helvetica', '', 10);

$html .= '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="6" style="background-color: #ADD8E6; color: black; text-align: center;">' . '<h2>' . 'PROPUESTA: ' . '</h2></th>';
$html .= '</tr>';
$html .= '<tr><th style="text-align: center;">NOMBRE</th><th style="text-align: center;">DESCRIPCION</th><th style="text-align: center;">PRECIO</th><th style="text-align: center;">CANTIDAD</th><th style="text-align: center;">DESCUENTO</th><th style="text-align: center;">TOTAL</th></tr>';
$html .= '</table>';

$subtotal = 0;
$subtotal_snd = 0;
$cont = 0;
$b=0;
foreach ($libros_seleccionados as $fila) {
    if($cont < 2 && $b == 0){
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['nombre']) . '</td>';
        $html .= '<td style="text-align: center;"><h5>' . htmlspecialchars($fila['descripcion']) . '</h5></td>';
        $html .= '<td style="text-align: center;"> $' . htmlspecialchars($fila['precioVenta']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['cantidad']) . '</td>';
        if ($fila['descuento'] == ""){
            $html .= '<td style="text-align: center;">' . ' ' . '</td>';    
        }else{
            $html .= '<td style="text-align: center;"> %' . htmlspecialchars($fila['descuento']) . '</td>';
        }
        $html .= '<td style="text-align: center;">$' . htmlspecialchars($fila['total']) . '</td>';
        $html .= '</tr>';   
        $precioUnidad = $fila['precioVenta'];
        $cantidad = $fila['cantidad'];
        $descuento = $fila['descuento'];
        $importe = $cantidad * $precioUnidad;
        $importe_descuento = $importe - ($importe * ($descuento/100));
        $subtotal += $importe;
        $subtotal_snd += $importe_descuento;
        $html .= '</table>';
        $cont ++;
    }else if ($b == 1 && $cont < 4){
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['nombre']) . '</td>';
        $html .= '<td style="text-align: center;"><h5>' . htmlspecialchars($fila['descripcion']) . '</h5></td>';
        $html .= '<td style="text-align: center;"> $' . htmlspecialchars($fila['precioVenta']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['cantidad']) . '</td>';
        if ($fila['descuento'] == ""){
            $html .= '<td style="text-align: center;">' . ' ' . '</td>';    
        }else{
            $html .= '<td style="text-align: center;"> %' . htmlspecialchars($fila['descuento']) . '</td>';
        }
        $html .= '<td style="text-align: center;">$' . htmlspecialchars($fila['total']) . '</td>';
        $html .= '</tr>';   
        $precioUnidad = $fila['precioVenta'];
        $cantidad = $fila['cantidad'];
        $descuento = $fila['descuento'];
        $importe = $cantidad * $precioUnidad;
        $importe_descuento = $importe - ($importe * ($descuento/100));
        $subtotal += $importe;
        $subtotal_snd += $importe_descuento;
        $html .= '</table>';
        $cont ++;
    }else{
    $b = 1;
    $cont = 0;
    $pdf->writeHTML($html, true, false, true, false, '');
    $html = ' ';
    $pdf->AddPage();
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['nombre']) . '</td>';
        $html .= '<td style="text-align: center;"><h5>' . htmlspecialchars($fila['descripcion']) . '</h5></td>';
        $html .= '<td style="text-align: center;"> $' . htmlspecialchars($fila['precioVenta']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($fila['cantidad']) . '</td>';
        if ($fila['descuento'] == ""){
            $html .= '<td style="text-align: center;">' . ' ' . '</td>';    
        }else{
            $html .= '<td style="text-align: center;"> %' . htmlspecialchars($fila['descuento']) . '</td>';
        }
        $html .= '<td style="text-align: center;">$' . htmlspecialchars($fila['total']) . '</td>';
        $html .= '</tr>';   
        $precioUnidad = $fila['precioVenta'];
        $cantidad = $fila['cantidad'];
        $descuento = $fila['descuento'];
        $importe = $cantidad * $precioUnidad;
        $importe_descuento = $importe - ($importe * ($descuento/100));
        $subtotal += $importe;
        $subtotal_snd += $importe_descuento;
        $html .= '</table>';
        $cont ++;
    }
}

    if($cont > 3){
    $pdf->writeHTML($html, true, false, true, false, '');
    $html = ' ';
    $pdf->AddPage();
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    $html = ' ';
    $html .= '<p></p>';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<td colspan="4" style="text-align: center;">' . 'Subtotal: ' . '</td>';
    $html .= '<td colspan="2" style="text-align: center;">$' . number_format($subtotal, 2) . '</td>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td colspan="4" style="text-align: center;">' . 'Subtotal con Descuento: ' . '</td>';
    $html .= '<td colspan="2" style="text-align: center;">$' . number_format($subtotal_snd, 2) . '</td>';
    $html .= '</tr>';
    $ivaPorcentaje = 0.16;
    $iva = $subtotal_snd * $ivaPorcentaje;
    $html .= '<tr>';
    $html .= '<td colspan="4" style="text-align: center;">' . 'I.V.A. (' . ($ivaPorcentaje * 100) . '%)' . '</td>';
    $html .= '<td colspan="2" style="text-align: center;">$' . number_format($iva, 2) . '</td>';
    $html .= '</tr>';
    $totalConIVA = $subtotal_snd + $iva;
    $html .= '<tr>';
    $html .= '<td colspan="4" style="text-align: center;">' . 'Total con I.V.A' . '</td>';
    $html .= '<td colspan="2" style="text-align: center;">$' . number_format($totalConIVA, 2) . '</td>';
    $html .= '</tr>';

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 12);
$pdf->Ln();
$pdf->MultiCell(0, 10, 'Sin más por el momento quedo de ustedes para cualquier aclaracion sobre el particular', 0, 'F');

$pdf->SetFont('helvetica','B',12);
$pdf->Cell(0, 5, "ATENTAMENTE", 0, 1);
$pdf->Ln();
$pdf->SetFont('helvetica','',10);
$pdf->Cell(0, 5, "$nombre_usuario", 0, 1);
$pdf->SetTextColor(0, 51, 153);
$pdf->Cell(0, 5, "$laboratorio_us", 0, 1);

$filename = 'cotizacion_cursos_' . date('YmdHis') . '.pdf';

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
    $productos_ids[] = $fila['nombre'];
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

    $nombre = $fila['nombre'];
    $cantidad = $fila['cantidad'];
    $sql_ventas = "SELECT ventas FROM cursos WHERE nombre = ?";
    $stmt_ventas = $conn->prepare($sql_ventas);
    $stmt_ventas->bind_param("s", $nombre);
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
        $sql_actualizar_ventas = "UPDATE cursos SET ventas = ? WHERE nombre = ?";
        $stmt_actualizar_ventas = $conn->prepare($sql_actualizar_ventas);
        $stmt_actualizar_ventas->bind_param("ss", $nuevo_ventas, $nombre);
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
