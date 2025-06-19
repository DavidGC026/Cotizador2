<?php
// Verificar si se ha recibido un ID válido
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Conectarse a la base de datos
        $conexion = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM articulos WHERE id = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        
        // Establecer parámetros
        $param_id = $_GET["id"];
        
        // Ejecutar la declaración preparada
        if ($stmt->execute()) {
            // Almacenar el resultado
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows == 1) {
                // Obtener la fila de resultados
                $fila = $resultado->fetch_assoc();

                // Cerrar la declaración preparada
                $stmt->close();
            } else {
                // No se encontró ningún artículo con ese ID
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }
    }
    
    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // El parámetro ID no se recibió o está vacío
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Artículo</title>
</head>
<body>
    <h2>Modificar Artículo</h2>
    <form action="actualizar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
        <label>Producto:</label>
        <input type="text" name="producto" value="<?php echo $fila['Producto']; ?>"><br>
        <label>Número de Artículo:</label>
        <input type="text" name="numero_articulo" value="<?php echo $fila['Numero_Articulo']; ?>"><br>
        <label>Descripción:</label>
        <textarea name="descripcion"><?php echo $fila['Descripcion']; ?></textarea><br>
        <label>ONNCCE:</label>
        <input type="text" name="onncce" value="<?php echo $fila['ONNCCE']; ?>"><br>
        <label>Precio de Venta:</label>
        <input type="text" name="precio_venta" value="<?php echo $fila['Precio_Venta']; ?>"><br>
        <label>Clase:</label>
        <input type="text" name="clase" value="<?php echo $fila['clase']; ?>"><br>
        <label>Ventas:</label>
        <input type="text" name="ventas" value="<?php echo $fila['ventas']; ?>"><br>
        <input type="submit" value="Guardar Cambios">
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
