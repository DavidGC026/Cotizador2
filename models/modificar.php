<!DOCTYPE html>
<html>
<head>
    <title>Buscar Artículos</title>
</head>
<body>
    <h2>Buscar Artículos</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Buscar por Número de Artículo, Norma ONNCCE o Descripción:</label>
        <input type="text" name="search_query">
        <input type="submit" value="Buscar">
    </form>

    <?php
    // Verificar si se ha enviado un formulario de búsqueda
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener el término de búsqueda
        $search_query = $_POST["search_query"];

        // Conectarse a la base de datos
        $conexion = new mysqli("localhost", "admin", "Imc590923cz4#", "mysql");

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para buscar en las columnas especificadas
        $sql = "SELECT * FROM articulos WHERE Numero_Articulo LIKE '%$search_query%' OR ONNCCE LIKE '%$search_query%' OR Descripcion LIKE '%$search_query%' OR Producto LIKE '%$search_query%'";

        // Ejecutar la consulta
        $resultado = $conexion->query($sql);

        // Verificar si se encontraron resultados
        if ($resultado->num_rows > 0) {
            // Mostrar los resultados en una tabla
            echo "<h3>Resultados de la búsqueda:</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Número de Artículo</th>
                        <th>Descripción</th>
                        <th>ONNCCE</th>
                        <th>Precio de Venta</th>
                        <th>Clase</th>
                        <th>Ventas</th>
                        <th>Acción</th>
                    </tr>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$fila["id"]."</td>";
                echo "<td>".$fila["Producto"]."</td>";
                echo "<td>".$fila["Numero_Articulo"]."</td>";
                echo "<td>".$fila["Descripcion"]."</td>";
                echo "<td>".$fila["ONNCCE"]."</td>";
                echo "<td>".$fila["Precio_Venta"]."</td>";
                echo "<td>".$fila["clase"]."</td>";
                echo "<td>".$fila["ventas"]."</td>";
                echo "<td><a href='editar.php?id=".$fila["id"]."'>Editar</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
    ?>
</body>
</html>
