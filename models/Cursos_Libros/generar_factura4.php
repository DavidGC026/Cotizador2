<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

// Verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../cliente2.php");
    exit();
}

// Recuperar datos de sesión
$usuario = $_SESSION['usuario'];
$usuario1 = $usuario;

// Recuperar datos procesados de la página HTML
$usuariopr = $_POST['usuariopr'];
$selected_table = $_POST['selected_table'];

$selected_rows_json = $_POST['selected_rows'];
$selected_rows = json_decode($selected_rows_json, true);
$precios_json = $_POST['precio'];
$precios = json_decode($precios_json, true);
$cantidades_json = $_POST['cantidad'];
$cantidades = json_decode($cantidades_json, true);
$descuentos_json = $_POST['descuento'];
$descuentos = json_decode($descuentos_json, true);

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

        $this->Image('logoimcyc.jpg', 155, 3, 22, 15, 'JPG', 'http://www.imcyc.com', '', true, 150, '', false, false, 0, false, false, false);

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


$mensaje = "Agradecemos de antemano la confianza depositada en el IMCYC para desarrollar la presente cotización";

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 10, $mensaje, 0, 'L');
$pdf->Ln();
$html = '<h2>Datos Procesados - IMCYC ' . $selected_table .'</h2>';

$html .= '<div class="table-responsive">';
$html .= '<table border="1">';
$html .= '<thead><tr>';
foreach ($selected_rows[0] as $key => $value) {
    if ($key !== 'ventas') {
        $html .= "<th>$key</th>";
    }
}
$html .= '<th>Cantidad</th>';
$html .= '<th>Subtotal</th>';
$html .= '</tr></thead>';
$html .= '<tbody>';

$total = 0;

foreach ($selected_rows as $index => $row) {
    $html .= '<tr>';
    foreach ($row as $key => $value) {
        if ($key !== 'ventas') {
            $html .= "<td>$value</td>";
        }
    }
    $html .= "<td>$cantidades[$index]</td>";
    $subtotal = $precios[$index] * $cantidades[$index] * (1 - ($descuentos[$index] / 100));
    $total += $subtotal;
    $html .= '<td>' . number_format($subtotal, 2) . '</td>';
    $html .= '</tr>';
}

$iva = $total * 0.16;
$total_con_iva = $total + $iva;

$html .= '</tbody></table></div>';
$html .= "<h4>Total: $" . number_format($total, 2) . "</h4>";
$html .= "<h4>IVA (16%): $" . number_format($iva, 2) . "</h4>";
$html .= "<h4>Total con IVA: $" . number_format($total_con_iva, 2) . "</h4>";
$html .= "<p></p>";

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$pdf->Ln();
$pdf->MultiCell(0, 5, 'Sin más por el momento quedo de ustedes para cualquier aclaracion sobre el particular', 0, 'F');
$pdf->Ln(10);
$pdf->SetFont('helvetica','B',12);
$pdf->Cell(0, 5, "ATENTAMENTE", 0, 1);
$pdf->Ln();
$pdf->SetFont('helvetica','',10);
$pdf->Cell(0, 5, "$nombre_usuario", 0, 1);
$pdf->SetTextColor(0, 51, 153);
$pdf->Cell(0, 5, "$laboratorio_us", 0, 1);


$filename = 'cotizacion_libros_' . date('YmdHis') . '.pdf';

$pdf->Output($filename, 'I');

$fecha = date('Y-m-d H:i:s');
$sql_insertar_cotizacion = "INSERT INTO cotizaciones (numCotizacion, folio, cliente, capturo, fecha, usuariocl) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insertar_cotizacion = $conn->prepare($sql_insertar_cotizacion);
$stmt_insertar_cotizacion->bind_param("ssssss", $numCotizacion, $folio, $cliente_nombre, $nombre_usuario, $fecha, $usuario);
$stmt_insertar_cotizacion->execute();

$conn->close();

$pdfFileName = '/var/www/html/cotizador/models/facturasLibros/' . $folio . '.pdf';
$pdf->Output($pdfFileName, 'F');
?>
