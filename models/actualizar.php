<?php
// Verificar si se ha enviado un formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectarse a la base de datos
        $conexion = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener los datos del formulario
    $id = $_POST["id"];
    $producto = $_POST["producto"];
    $numero_articulo = $_POST["numero_articulo"];
    $descripcion = $_POST["descripcion"];
    $onncce = $_POST["onncce"];
    $precio_venta = $_POST["precio_venta"];
    $clase = $_POST["clase"];
    $ventas = $_POST["ventas"];

    // Preparar la consulta SQL para actualizar el artículo
    $sql = "UPDATE articulos SET Producto=?, Numero_Articulo=?, Descripcion=?, ONNCCE=?, Precio_Venta=?, clase=?, ventas=? WHERE id=?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular variables a la declaración preparada como parámetros
        $stmt->bind_param("ssssdssi", $producto, $numero_articulo, $descripcion, $onncce, $precio_venta, $clase, $ventas, $id);
        
        // Ejecutar la declaración preparada
        if ($stmt->execute()) {
            // Redirigir al usuario de vuelta a la página principal
            header("location: modificar.php");
            exit();
        } else {
            echo "Error al actualizar el artículo.";
        }

        // Cerrar la declaración preparada
        $stmt->close();
    }
    
    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>
