<?php

$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "mysql";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $apellido_p = $_POST["apellido_p"];
    $apellido_m = $_POST["apellido_m"];
    $empresa = $_POST["empresa"];
    $puesto = $_POST["puesto"];
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $contacto = $_POST["contacto"];


    $sql = "INSERT INTO clientes (nombre, apellido_p, apellido_m, empresa,puesto, usuario, correo, contacto)
            VALUES ('$nombre', '$apellido_p', '$apellido_m', '$empresa','$puesto', '$usuario', '$correo', '$contacto')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
        header("Location: registro.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

