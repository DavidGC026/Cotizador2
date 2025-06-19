<?php
session_start();
include('cliente2.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario = $_POST['usuario'];
$usuariopr = $_POST['usuariopr'];

$sql_clientes = "SELECT * FROM clientes WHERE usuario = '$usuario'";
$result_clientes = $conn->query($sql_clientes);

if ($result_clientes->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    header("Location: Cursos_Libros/cotizacionesli.php?usuariocl=$usuario&usuariopr=$usuariopr");
    exit();
} else {
    echo "Inicio de sesión fallido. Verifique sus credenciales.";
}

$conn->close();
?>




