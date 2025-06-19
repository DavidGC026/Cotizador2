<?php
$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "librosimcyc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla = $_POST['tabla'];
    $datos = $_POST;

    unset($datos['tabla']);

    $campos = implode(', ', array_keys($datos));
    $valores = "'" . implode("', '", array_values($datos)) . "'";
    $sql = "INSERT INTO $tabla ($campos) VALUES ($valores)";

    if ($conn->query($sql) === TRUE) {
        echo "Registro insertado correctamente en la tabla $tabla.";
    } else {
        echo "Error al insertar registro: " . $conn->error;
    }
}

$conn->close();
?>
