<?php
    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if(isset($_GET['folio'])) {
    $folio = $_GET['folio'];
    $usuario = $_GET['usuario'];

    $asunto = "Cotización seleccionada";

    $mensaje = "Estimado cliente,\n\n";
    $mensaje .= "Ha solicitado enviar por correo la cotización con el folio {$folio}.\n\n";

    $archivo = "/var/www/html/cotizador/models/archivos/{$folio}.pdf";
    if(file_exists($archivo)) {
        $enlace = "http://grabador.imcyc.com/cotizador/models/archivos/{$folio}.pdf";
        $mensaje .= "Descargar: {$enlace}\n";
    } else {
        $mensaje .= "Error: El archivo no existe\n";
    }

    $mensaje .= "\nAtentamente,\nIMCYC";


    $sql_cliente = "SELECT id, nombre, apellido_p, apellido_m, empresa, puesto, contacto, correo FROM clientes WHERE usuario = ?";
    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $usuario);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();

    $cliente_data = $result_cliente->fetch_assoc();

    $conn->close();

    $cliente_correo = $cliente_data['correo'];

    $correo_destinatario = $cliente_correo;

    $headers = "From: imcycprueba2024@gmail.com\r\n";
    $headers .= "Reply-To: imcycprueba2024@gmail.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if(mail($correo_destinatario, $asunto, $mensaje, $headers)) {
        echo "El enlace de descarga se ha enviado por correo electrónico a $correo_destinatario";
    } else {
        echo "Ha ocurrido un error al enviar el correo electrónico.";
    }
} else {
    echo "No se ha proporcionado un folio de cotización.";
}
?>

