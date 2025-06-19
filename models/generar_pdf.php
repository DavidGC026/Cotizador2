<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generarPDF'])) {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
    $usuariopr = $_POST['usuariopr'];
    $costo_total = isset($_POST['costoTotal']) ? $_POST['costoTotal'] : '';
    $duracionPrueba = isset($_POST['duracionPrueba']) ? $_POST['duracionPrueba'] : '';
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

    $sql_cliente = "SELECT id, nombre, apellido_p, apellido_m, empresa, puesto, contacto, correo FROM clientes WHERE usuario = ?";
    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $usuario);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();

    $cliente_data = $result_cliente->fetch_assoc();

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

    $cliente_nombre = $cliente_data['nombre'] . ' ' . $cliente_data['apellido_p'] . ' ' . $cliente_data['apellido_m'];
    $cliente_nombre1 = $cliente_data['nombre'];
    $cliente_puesto = $cliente_data['puesto'];
    $cliente_empresa = $cliente_data['empresa'];
    $cliente_contacto = $cliente_data['contacto'];
    $cliente_correo = $cliente_data['correo'];

    $referencia = $referencia1;


    class MYPDF extends TCPDF {

        public function Header() {
            $this->SetY(10);
            $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
            $this->Line(10, $this->GetY() + 9, $this->getPageWidth() - 10, $this->GetY() + 9);

            $this->Image('logoimcyc.jpg', 155, 3, 22, 15, 'JPG', 'http://www.imcyc.com', '', true, 150, '', false, false, 0, false, false, false);

            $this->SetTextColor(0, 51, 153);
            $this->SetFont('helvetica', 'B', 10);

            $this->Cell(0, 50, 'INSTITUTO MEXICANO DEL CEMENTO Y DEL CONCRETO, A.C', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            }

            public function Footer() {

            $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
            $this->Line(10, $this->getY() - 22, $this->getPageWidth() - 10, $this->getY() - 22);

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
    $numCotizacion = $folio.'-'.$yearac;
    $pdf->Cell(0, 4, "Ciudad de México, a $fechaActual", 0, 1, 'R');
    $pdf->Cell(0, 4, "$numCotizacion", 0, 1, 'R');
    $pdf->Cell(0, 4, $cliente_nombre, 0, 1);
    $pdf->Cell(0, 4, $cliente_puesto, 0, 1);
    $pdf->Cell(0, 4, $cliente_empresa, 0, 1);
    $pdf->Cell(0, 4, $cliente_contacto, 0, 1);
    $pdf->Cell(0, 4, $cliente_correo, 0, 1);
    $pdf->Cell(0, 4, "Referencia: '$referencia'", 0, 1, 'R');
    $pdf->Ln();
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(0, 5, "Estimado $cliente_nombre:", 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $nombre_producto1 = '';

    $conn = new mysqli($servername, $username, $password, $dbname);

    foreach ($articulos_seleccionados as $articulo) {
        $numeroArticulo = $articulo['numeroArticulo'];
        $sql_producto = "SELECT Producto FROM articulos WHERE Numero_Articulo = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("s", $numeroArticulo);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();
        $row_producto = $result_producto->fetch_assoc();
        $nombre_producto = $row_producto['Producto'];

        $nombre_producto1 = $nombre_producto1 . ', ' . $nombre_producto . ' ';
    }
    $pdf->MultiCell(0, 10, "En seguimiento a su solicitud, a continuación presentamos a su consideración la propuesta económica para realizar el servicio de laboratorio de ensayos para sus muestras de ($nombre_producto1):", 0, 'L');

    // 1.-PRESUPUESTOS
    $pdf->SetFont('helvetica','B', 12);
    $pdf->Cell(0, 10, '        1.  PRESUPUESTO', 0, 1, 'L');
    $pdf->SetFont('helvetica','',10);

    $numeroEnPalabras = shell_exec("python3 convertir_numero.py $costo_total");

    $texto = "El costo por la ejecución de los ensayos y emisión de reporte de resultados es de $ $costo_total ($numeroEnPalabras pesos M.N. 00/100) más I.V.A. o cualquier otro impuesto que lo sustituya.";
    $texto = preg_replace("/[\r\n|\n|\r]+/", " ", $texto);

    $pdf->MultiCell(0, 15, $texto , 0, 'L');
    // 2.-Alcance
    $pdf->SetFont('helvetica','B', 12);
    $pdf->Cell(0, 10, '        2. ALCANCE', 0, 1, 'L');
    $pdf->SetFont('helvetica','',10);
    $pdf->MultiCell(0, 0, "De acuerdo con su solicitud, el servicio incluye los siguientes ensayos:", 0, 'L');

    $pdf->Ln();
    $folioIncremental = 1;

    foreach ($articulos_seleccionados as $articulo) {
        $numeroArticulo = $articulo['numeroArticulo'];
        $cantidad = $articulo['cantidad'];
        $total = $articulo['total'];
        $descripcion = $articulo['descripcion'];

        $sql_norma = "SELECT ONNCCE, Producto FROM articulos WHERE Numero_Articulo = ?";
        $stmt_norma = $conn->prepare($sql_norma);
        $stmt_norma->bind_param("s", $numeroArticulo);
        $stmt_norma->execute();
        $result_norma = $stmt_norma->get_result();
        $row_norma = $result_norma->fetch_assoc();
        $norma_onncce = $row_norma['ONNCCE'];
        $nombre_producto = $row_norma['Producto'];

        $norma_texto = ($norma_onncce != "") ? 'se realiza en conformidad con el estándar ' . $norma_onncce : ".";

        $texto_alcance ='La determinación de ' .  $nombre_producto . ' a ' . $cantidad . ' muestras de ' . $descripcion . ', ' . $norma_texto;

        $texto_alcance = preg_replace("/[\r\n|\n|\r]+/", " ", $texto_alcance);

        $pdf->Cell(10, 5, '•', 0, 0, 'R');
        $pdf->MultiCell(160, 3, $texto_alcance, 0, 'L');
        $folioIncremental++;
    }

    // 3.Tiempo de Duracion
    $pdf->SetFont('helvetica','B', 12);
    $pdf->Cell(0, 10, '        3.TIEMPO DE DURACION', 0, 1, 'L');
    $pdf->SetFont('helvetica','',10);
    $pdf->MultiCell(0,10,"La preparación de las muestras y la ejecución los ensayos se concluyen en un tiempo aproximado de ($duracionPrueba) días hábiles, contados a partir de la fecha en que se cumplan las siguientes condiciones:",0,'L');

    $observaciones = array('Las muestras se deben encontrar en las instalaciones del laboratorio del IMCYC','El servicio cuenta con pago de anticipo o emisión de orden de compra.','El cliente indicó toda la información requerida para llevar a cabo el ensayo.'
    );

    $pdf->SetFillColor(200, 220, 255);

    foreach ($observaciones as $observacion) {
        $pdf->Cell(10, 5, '•', 0, 0, 'R');
        $pdf->MultiCell(170, 5, $observacion , 0, 'L');
    }

    // 4. EMISIÓN DE RESULTADOS
    $pdf->Ln();
    $pdf->SetFont('helvetica','B', 12);
    $pdf->Cell(0, 10, '        4. EMISIÓN DE RESULTADOS', 0, 1, 'L');
    $pdf->SetFont('helvetica','',10);
    $pdf->MultiCell(0, 10, 'La emisión del informe final se realiza dentro de los 5 días hábiles siguientes al término del ensayo y se entregará al cliente en un archivo protegido en formato PDF.', 0, 'L');
    $pdf->MultiCell(0, 10, 'En caso de requerir informes preliminares a edades intermedias, se deben solicitar previamente con el responsable de su servicio, y tendrán un costo de $ 500.00 (quinientos pesos M.N. 00/100) más I.V.A. por cada informe preliminar.', 0, 'L');
    $pdf->MultiCell(0, 10, 'La emisión de informes en físico, con sello del Instituto, se debe solicitar previamente y tiene un costo adicional de $ 500.00 (quinientos pesos M.N. 00/100) más I.V.A.', 0, 'L');
    $pdf->AddPage();
    // 5. RESUMEN DEL PRESUPUESTO


    $sql_producto = "SELECT Producto FROM articulos WHERE Numero_Articulo = ?";
    $stmt_producto = $conn->prepare($sql_producto);
    $stmt_producto->bind_param("s", $numeroArticulo);
    $stmt_producto->execute();
    $result_producto = $stmt_producto->get_result();
    $row_producto = $result_producto->fetch_assoc();
    $nombre_producto = $row_producto['Producto'];

    $pdf->Ln();
    $pdf->SetFont('helvetica','B', 12);
    $pdf->Cell(0, 10, '        5. RESUMEN DEL PRESUPUESTO', 0, 1, 'L');
    $pdf->SetFont('helvetica','',6);

    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(10, 10, 'N.O.', 1, 0, 'C', 1);
    $pdf->Cell(20, 10, 'U', 1, 0, 'C', 1);
    $pdf->Cell(20, 10, 'P.U.', 1, 0, 'C', 1);
    $pdf->Cell(10, 10, 'CANT', 1, 0, 'C', 1);
    $pdf->Cell(20, 10, 'IMPORTE', 1, 0, 'C', 1);
    $pdf->Cell(15, 10, 'DESCUENTO', 1, 0, 'C', 1);
    $pdf->Cell(20, 10, 'IMPORTE FINAL', 1, 0, 'C', 1);
    $pdf->Cell(50, 10, 'CONCEPTO', 1, 1, 'C', 1);

    $subtotal = 0;
    $subtotal_snd = 0;
    $pdf->SetFont('helvetica','',8);
    foreach ($articulos_seleccionados as $key => $articulo) {

        $numeroArticulo = $articulo['numeroArticulo'];
        $descripcion = $articulo['descripcion'];
        $precioUnidad = $articulo['precioVenta'];
        $cantidad = $articulo['cantidad'];
        $importe = $cantidad * $precioUnidad;
        $descuento = $articulo['descuento'];
        $importe_descuento = $importe - ($importe * ($descuento/100));

        $sql_producto = "SELECT ONNCCE, Producto FROM articulos WHERE Numero_Articulo = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("s", $numeroArticulo);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();
        $row_producto = $result_producto->fetch_assoc();
        $nombre_producto = $row_producto['Producto'];
        $norma_onncce = $row_producto['ONNCCE'];
        $norma_texto = ($norma_onncce != "") ? ' ( ' . $norma_onncce . ' )' : ".";

        $texto_descripcion= $descripcion . ' ' . $norma_texto;

        $texto_descripcion = preg_replace("/[\r\n|\n|\r]+/", " ", $texto_descripcion);

        $subtotal += $importe_descuento;
        $subtotal_snd += $importe;

        $pdf->Cell(15, 6, '', 0, 'L');
        $pdf->Cell(10, 18, $key + 1, 1, 0, 'C');
        $pdf->Cell(20, 18, $nombre_producto, 1, 0, 'C');
        $pdf->Cell(20, 18, '$' . number_format($precioUnidad, 2), 1, 0, 'C');
        $pdf->Cell(10, 18, $cantidad, 1, 0, 'C');
        $pdf->Cell(20, 18, '$' . number_format($importe, 2), 1, 0, 'C');
        $pdf->Cell(15, 18, '%' . $descuento, 1, 0, 'C');
        $pdf->Cell(20, 18, '$' . number_format($importe_descuento, 2), 1, 0, 'C');
        $pdf->MultiCell(50, 18, $texto_descripcion , 1, 'J');
    }

    $conn->close();

    $pdf->SetFont('helvetica','',10);
    // Subtotal
    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(135, 6, 'Subtotal', 1, 0, 'R');
    $pdf->Cell(30, 6, '$' . number_format($subtotal_snd, 2), 1, 1, 'C');
    $pdf->Cell(15, 6, '', 0, 'L');
    $descuento_tot = $subtotal_snd - $subtotal;
    $pdf->Cell(135, 6, 'Descuento', 1, 0, 'R');
    $pdf->Cell(30, 6, '$' . number_format($descuento_tot, 2), 1, 1, 'C');

    /*$pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(135, 6, 'Subtotal con Descuento', 1, 0, 'R');
    $pdf->Cell(30, 6, '$' . number_format($subtotal, 2), 1, 1, 'C');
    */
    $ivaPorcentaje = 0.16;
    $iva = $subtotal * $ivaPorcentaje;
    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(135, 6, 'I.V.A. (' . ($ivaPorcentaje * 100) . '%)', 1, 0, 'R');
    $pdf->Cell(30, 6, '$' . number_format($iva, 2), 1, 1, 'C');

    // Total con IVA
    $pdf->Cell(15, 6, '', 0, 'L');
    $totalConIVA = $subtotal + $iva;
    $pdf->Cell(135, 6, 'Total con I.V.A.', 1, 0, 'R');
    $pdf->Cell(30, 6, '$' . number_format($totalConIVA, 2), 1, 1, 'C');

    $numeroEnPalabras = shell_exec("python3 convertir_numero.py $totalConIVA");
    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(165, 5, "($numeroEnPalabras pesos 00/100 M.N.)", 1, 0, 'C', 2);


    // 6. OBSERVACIONES
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, '        6. OBSERVACIONES', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetMargins(10, 25, 30);

    $observaciones = array(
        'Las muestras deberán ser entregadas en las instalaciones del laboratorio, ubicadas en Constitución No. 50 Col. Escandón, Del. Miguel Hidalgo, Ciudad de México, C.P. 11800, en un horario de 9:00 a 13:30 y de 15:30 a 18:00 horas.',
        'La forma de pago será del 100% o bien el 50 % de anticipo y, el 50 % restante, previo a la entrega de informe. Para poder programar el servicio se debe realizar el depósito a las siguientes cuentas a nombre del Instituto Mexicano del Cemento y del Concreto, A.C.:'
    );

    $pdf->SetFillColor(200, 220, 255);

    foreach ($observaciones as $observacion) {
        $pdf->Cell(10, 5, '• ', 0, 0, 'R');
        $pdf->MultiCell(170, 5, $observacion , 0, 'L');
    }

    // DATOS DE LA CUENTA IMCYC
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetFillColor(200, 220, 255);

    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(50, 6, 'DATOS DE LA CUENTA IMCYC', 1, 0, 'C', 1);
    $pdf->Cell(50, 6, 'BANAMEX', 1, 0, 'C');
    $pdf->Cell(50, 6, 'BBVA BANCOMER', 1, 1, 'C');

    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(50, 6, 'No. de Cuenta', 1, 0, 'L' , 1);
    $pdf->Cell(50, 6, '3683579', 1, 0, 'L');
    $pdf->Cell(50, 6, '0444104870', 1, 1, 'L');

    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(50, 6, 'No. de Cuenta CLABE', 1, 0, 'L' , 1);
    $pdf->Cell(50, 6, '002 1800 2703683579 7', 1, 0, 'L');
    $pdf->Cell(50, 6, '012 1800 0444104870 0', 1, 1, 'L');

    $pdf->Cell(15, 6, '', 0, 'L');
    $pdf->Cell(50, 6, 'Número y nombre de la Sucursal', 1, 0, 'L' , 1);
    $pdf->Cell(50, 6, '270 San Ángel', 1, 0, 'L');
    $pdf->Cell(50, 6, '3533, San José Insurgentes', 1, 1, 'L');

    $pdf->Ln();

    $pdf->SetFont('helvetica', '', 10);
    $observaciones = array(
        'El presente presupuesto tiene una vigencia de 15 días hábiles a partir de su fecha de emisión.',
        'Cualquier trabajo adicional no considerado en el presente presupuesto se cobrará de acuerdo con los precios de nuestra lista vigente.',
        'El presente presupuesto incluye únicamente el reporte de los resultados obtenidos en los ensayos, el laboratorio del IMCYC no realiza declaraciones de conformidad de los productos ensayados.',
        'En caso de requerir declaración de conformidad, el cliente debe proporcionar al laboratorio la regla de decisión que requiere para sus muestras, incluyendo el nivel de riesgo asociado.',
        'El alcance de nuestras acreditaciones No. C-053-039/11, vigente a partir del 24 de marzo del 2011, y No. MM-0227-020/10, vigente a partir del 22 de octubre de 2010, se puede consultar en la página www.ema.org.mx',
        'En caso de requerirse una subcontratación será necesaria la aprobación previa del cliente.',
        'En caso de llevarse a cabo el servicio, las muestras se conservarán por un periodo de 20 días hábiles a partir del término de los ensayos, de no ser reclamadas por el cliente, el IMCYC podrá disponer de las mismas.',
        'Puede consultar nuestro aviso de privacidad en la página http://www.imcyc.com/politica-de privacidad/',
        'Una vez concluido el servicio, solicitamos su apoyo para la evaluación del mismo en https://forms.gle/Q11QvqunLbphGsNb8'
    );

    $pdf->SetFillColor(200, 220, 255);

    foreach ($observaciones as $observacion) {
        $pdf->Cell(10, 5, '• ', 0, 0, 'R');
        $pdf->MultiCell(170, 5, $observacion , 0, 'L');
    }

    $pdf->Ln();
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(10, 10 , 'Para llevar a cabo su servicio, le recordamos:', 0, 1, 'L');

    $observaciones = array(
        'Entregar copia de los formatos de muestreo, en el que se incluye la identificación de las muestras (si aplica).',
        'Para el ensaye a flexión del elemento portante el cliente deberá especificar la siguiente información:',
        '    - Distancia entre ejes de vigueta (E).',
        '    - Valor de la carga de colado (Wm).',
        '    - Valor de la longitud de autoportancia (La).',
        '    - Momento Resistente (Mr).',
        '    - Peso propio del sistema.',
        'Las muestras deberán estar bien identificadas y se requieren por lo menos 00 kg de cada muestra.',
        'Es importante que la muestra se proteja de contaminación y dentro de un recipiente adecuado para su traslado.',
        'Se requiere mínimo 2 litros por muestra de agua.',
        'El concreto debe tener la edad especificada para poder extraer las muestras. El diámetro de los núcleos debe ser cuando menos de 3 veces el tamaño máximo nominal del agregado grueso y nunca menor a 48 mm.',
        'Para evaluar la resistencia a compresión del concreto colocado, se deberá extraer una muestra compuesta por 3 núcleos del mismo elemento.',
        'Se requiere que se dé acceso al personal con equipo y un vehículo durante el tiempo que duren los trabajos de campo. El horario de labores del personal será de lunes a viernes de las 9:30 a las 18:00 horas con una hora de comida.',
        'Se recomienda la asistencia, compañía y vigilancia por parte del CLIENTE durante los trabajos de campo, al menos al inicio de los trabajos para seleccionar los elementos.',
        'Se requiere que los elementos estén accesibles y libres.',
        'Es responsabilidad del CLIENTE proporcionar: agua, energía eléctrica y andamios seguros en caso de requerirse.'
    );

    $pdf->SetFillColor(200, 220, 255);

    foreach ($observaciones as $observacion) {
        $pdf->Cell(5, 5, '', 0, 0, 'R');
        $pdf->MultiCell(170, 5, $observacion , 0, 'L');
    }

    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql_usuario = "SELECT nombre, laboratorio FROM usuarios WHERE usuariopr = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("s", $usuariopr);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $row_usuario = $result_usuario->fetch_assoc();
    $nombre_usuario = $row_usuario['nombre'];
    $laboratorio = $row_usuario['laboratorio'];

    $pdf->Ln();
    $pdf->MultiCell(0, 10, 'Sin otro particular y seguros de poderles servir en esta ocasión, quedamos a sus órdenes para cualquier aclaración.', 0, 'F');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(95, 10, 'Elaboró', 0, 0, 'C');
    $pdf->Cell(95, 10, 'Aprobó', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(95, 5, $nombre_usuario, 0, 0, 'C');
    $pdf->Cell(95, 5, 'Ing. Mario Alberto Hernández H.', 0, 1, 'C');
    $pdf->Cell(95, 5, "Laboratorio de $laboratorio", 0, 0, 'C');
    $pdf->Cell(95, 5, 'Gerente Técnico', 0, 1, 'C');

    $conn->close();

    $pdfFileName = 'documento1.pdf';
    $pdf->Output($pdfFileName,'I');
    $folio = $cliente_nombre1 . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);

    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql_verificar_folio = "SELECT id FROM cotizaciones WHERE folio = ?";
    $stmt_verificar_folio = $conn->prepare($sql_verificar_folio);
    $stmt_verificar_folio->bind_param("s", $folio);
    $stmt_verificar_folio->execute();
    $result_verificar_folio = $stmt_verificar_folio->get_result();

    if ($result_verificar_folio->num_rows > 0) {
        die("El folio ya existe en la base de datos.");
    }

    $fecha = date('Y-m-d H:i:s');
    $capturo = $nombre_usuario;
    $sql_insertar_cotizacion = "INSERT INTO cotizaciones (numCotizacion,folio, cliente, capturo, fecha, usuariocl) VALUES (?,?, ?, ?, ?, ?)";
    $stmt_insertar_cotizacion = $conn->prepare($sql_insertar_cotizacion);
    $stmt_insertar_cotizacion->bind_param("ssssss",$numCotizacion, $folio, $cliente_nombre, $capturo, $fecha, $usuario);
    $stmt_insertar_cotizacion->execute();

    $pdfFileName = '/var/www/html/cotizador/models/archivos/' . $folio . '.pdf';
    $pdf->Output($pdfFileName, 'F');
    $asunto = 'Cotización Generada';
    $mensaje = 'Estimado ' . $cliente_nombre . ', adjunto encontrará la cotización solicitada.';

    $remitente = 'imcycprueba2024@gmail.com';
    $destinatario = $cliente_correo;

    $headers = 'From: ' . $remitente . "\r\n" .
    'Reply-To: ' . $remitente . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $adjunto = '/var/www/html/cotizador/archivos/' . $folio . '.pdf';
    if (file_exists($adjunto)) {
        $resultado = mail($destinatario, $asunto, $mensaje, $headers, "-f $remitente");
        if ($resultado) {
            echo '<script>alert("El correo ha sido enviado correctamente.");</script>';
        } else {
            echo '<script>alert("Hubo un error al enviar el correo.");</script>';
        }
    } else {
        echo '<script>alert("El archivo adjunto no existe.");</script>';
    }

    $fecha = date('Y-m-d');
    $productos_ids = [];
    $cantidades = [];
    $ids = [];
    foreach ($articulos_seleccionados as $key => $articulo) {
        $productos_ids[] = $articulo['numeroArticulo'];
        $cantidades[] = $articulo['cantidad'];
        $ids[] = $articulo['id'];
    }

    $productos_ids_str = implode(',', $productos_ids);
    $cantidades_str = implode(',', $cantidades);
    $ids_str = implode(',',$ids);

    $sql_insertar_cotizacionf = "INSERT INTO cotizacionesf (Fecha, id_productos, productos, cantidades, importe, folio_cot) VALUES (?,?,?,?,?,?)";
    $stmt_insertar_cotizacionf = $conn->prepare($sql_insertar_cotizacionf);

    if ($stmt_insertar_cotizacionf) {
        $ids_str = implode(',', $ids); // Convertir el array de ids a una cadena
        $stmt_insertar_cotizacionf->bind_param("ssssss", $fecha, $ids_str, $productos_ids_str, $cantidades_str, $totalConIVA, $folio);
        $stmt_insertar_cotizacionf->execute();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt_insertar_cotizacionf->close();

    foreach ($articulos_seleccionados as $key => $articulo) {

        $numeroArticulo = $articulo['numeroArticulo'];
        $descripcion = $articulo['descripcion'];
        $precioUnidad = $articulo['precioVenta'];
        $cantidad = $articulo['cantidad'];
        $sql_ventas = "SELECT ventas FROM articulos WHERE Numero_Articulo = ?";
        $stmt_ventas = $conn->prepare($sql_ventas);
        $stmt_ventas->bind_param("s", $numeroArticulo);
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
            $sql_actualizar_ventas = "UPDATE articulos SET ventas = ? WHERE Numero_Articulo = ?";
            $stmt_actualizar_ventas = $conn->prepare($sql_actualizar_ventas);
            $stmt_actualizar_ventas->bind_param("ss", $nuevo_ventas, $numeroArticulo);
            $stmt_actualizar_ventas->execute();
        }
    }

    $conn->close();
} else {
    exit();
}
?>
