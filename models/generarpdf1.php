<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generarPDF'])) {
    $costo_total = isset($_POST['costoTotal']) ? $_POST['costoTotal'] : '';
    $articulos_seleccionados_json = isset($_POST['datosTabla']) ? $_POST['datosTabla'] : '[]';
    $articulos_seleccionados = json_decode($articulos_seleccionados_json, true);

    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql_last_id = "SELECT id FROM cotizaciones ORDER BY id DESC LIMIT 1";
    $result_last_id = $conn->query($sql_last_id);

    if ($result_last_id->num_rows > 0) {
        $row = $result_last_id->fetch_assoc();
        $last_id = $row["id"];
        $next_id = $last_id + 1;
        $folio = "COT-GT-" . str_pad($next_id, 4, "0", STR_PAD_LEFT);
    } else {
        $folio = "COT-GT-0001";
    }

    $contadores = array();

    foreach ($articulos_seleccionados as $articulo) {
        $producto = $articulo['Producto'];
        if (isset($contadores[$producto])) {
            $contadores[$producto]++;
        } else {
            $contadores[$producto] = 1;
        }
    }

    $contadores = array();

    foreach ($articulos_seleccionados as $articulo) {
        $numeroArticulo = $articulo['numeroArticulo'];

        $sql_producto = "SELECT Producto FROM articulos WHERE Numero_Articulo = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("s", $numeroArticulo);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();
        $row_producto = $result_producto->fetch_assoc();
        $nombre_producto = $row_producto['Producto'];

        if (isset($contadores[$nombre_producto])) {
            $contadores[$nombre_producto]++;
        } else {
            $contadores[$nombre_producto] = 1;
        }
    }

    $producto_mas_repetido = null;
    $max_cantidad = 0;
    foreach ($contadores as $producto => $cantidad) {
        if ($cantidad > $max_cantidad) {
            $max_cantidad = $cantidad;
            $producto_mas_repetido = $producto;
        }
    }

    $referencia1 = "Cotizacion para $producto_mas_repetido";

    $conn->close();

    $referencia = $referencia1;

    class MYPDF extends TCPDF {
        public function Header() {
            $this->SetY(10);
            $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
            $this->Line(10, $this->GetY() + 9, $this->getPageWidth() - 10, $this->GetY() + 9);
            $this->Image('logoimcyc.jpg', 155, 3, 22, 15, 'JPG', 'http://www.imcyc.com', '', true, 150, '', false, false, 0, false, false);
            $this->SetTextColor(0, 51, 153);
            $this->SetFont('helvetica', 'B', 10);
            $this->Cell(0, 50, 'INSTITUTO MEXICANO DEL CEMENTO Y DEL CONCRETO, A.C', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        }

        public function Footer() {
            $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
            $this->Line(10, $this->getY() - 22, $this->getPageWidth() - 10, $this->getY() - 22);
            $this->SetY(-25);
            $this->SetTextColor(0, 51, 153);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
            $this->SetY(-20);
            $this->Cell(0, 10, 'Fecha de impresión: ' . date('d/m/Y h:i:s a'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Cotización');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Referencia: ' . $referencia, 0, 1, 'L');
    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 10, "Por este medio le hacemos llegar la cotización de los productos solicitados, esperando que sean de su interés.", 0, 'L');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(50, 5, 'Cantidad', 1, 0, 'C');
    $pdf->Cell(100, 5, 'Descripción', 1, 0, 'C');
    $pdf->Cell(40, 5, 'Precio Unitario', 1, 1, 'C');

    foreach ($articulos_seleccionados as $articulo) {
        $cantidad = $articulo['Cantidad'];
        $descripcion = $articulo['Producto'];
        $precio_unitario = $articulo['Precio_Unitario'];
        $pdf->Cell(50, 5, $cantidad, 1, 0, 'C');
        $pdf->Cell(100, 5, $descripcion, 1, 0, 'C');
        $pdf->Cell(40, 5, '$' . $precio_unitario, 1, 1, 'C');
    }

    $pdf->Ln();
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, "Costo total: $" . number_format($costo_total, 2), 0, 1, 'R');

    $pdf->Ln();
    $pdf->MultiCell(0, 10, "Quedamos a sus órdenes para cualquier duda o aclaración.", 0, 'L');
    $pdf->Ln();
    $pdf->Output('cotizacion.pdf', 'I');
}
?>
