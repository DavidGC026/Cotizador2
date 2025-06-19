<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "Imc590923cz4#";
$dbname = "librosimcyc";

// Obtener datos del formulario
$categoria = $_POST['categoria'];
$nombres_campos = $_POST['nombres_campos'];
$tipos_campos = $_POST['tipos_campos'];

// Reemplazar espacios en el nombre de la categoría por guiones bajos
$categoria = str_replace(' ', '_', $categoria);

// Campos que se agregarán automáticamente si no están presentes
$campos_automaticos = array("precio", "ventas");

// Verificar y agregar campos automáticamente
foreach ($campos_automaticos as $campo) {
    if (!in_array($campo, $nombres_campos)) {
        array_push($nombres_campos, $campo);
        array_push($tipos_campos, "INT");
    }
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Construcción de la consulta SQL para crear la tabla
$sql = "CREATE TABLE `$categoria` (id INT AUTO_INCREMENT PRIMARY KEY";

// Agregar los campos a la consulta SQL
for ($i = 0; $i < count($nombres_campos); $i++) {
    $nombre_campo = $nombres_campos[$i];
    $tipo_campo = $tipos_campos[$i];

    // Definir una longitud predeterminada para campos VARCHAR
    $longitud = ($tipo_campo == "VARCHAR") ? "(255)" : ""; // Establece una longitud predeterminada de 255 para campos VARCHAR

    // Agregar el campo con su tipo y longitud
    $sql .= ", `$nombre_campo` $tipo_campo$longitud";
}

$sql .= ")";

echo "Consulta SQL: $sql"; // Imprimir la consulta SQL para depurar

// Ejecución de la consulta SQL
if ($conn->query($sql) === TRUE) {
    echo "Nueva categoría agregada correctamente.";
} else {
    echo "Error al agregar la categoría: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>

