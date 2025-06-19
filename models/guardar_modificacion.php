<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $empresa = $_POST['empresa'];
    $puesto = $_POST['puesto'];
    $correo = $_POST['correo'];
    $contacto = $_POST['contacto'];

    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";

    $conexion = new mysqli($servername, $username, $password, $dbname);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "UPDATE clientes SET nombre='$nombre', apellido_p='$apellido_p', apellido_m='$apellido_m', empresa='$empresa', puesto='$puesto', correo='$correo', contacto='$contacto' WHERE id=$id_cliente";

    if ($conexion->query($sql) === TRUE) {
        echo "Los datos del cliente se han actualizado correctamente.";
        header("Location: seleccionarcl.php");
    } else {
        echo "Error al actualizar los datos del cliente: " . $conexion->error;
    }
    $conexion->close();
} else {
    echo "Acceso no autorizado.";
}
?>

