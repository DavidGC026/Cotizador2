<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../cliente2.php");
    exit();
    }

$usuario = $_SESSION['usuario'];
$usuario1 = $usuario;


$usuariopr = $_GET['usuariopr'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mostrar Datos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 30px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-secondary:hover {
            background-color: #495057;
            border-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Datos de la Tabla Seleccionada <?php echo $usuariopr?></h2>
        <?php
        if(isset($_GET['tabla'])) {
            $servername = "localhost";
            $username = "admin";
            $password = "Imc590923cz4#";
            $dbname = "librosimcyc";
            $selected_table = $_GET['tabla'];

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $data_query = "SELECT * FROM $selected_table";
            $data_result = $conn->query($data_query);

            if ($data_result->num_rows > 0) {
                echo "<form action='' method='post'>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead class='thead-light'><tr>";
                echo "<th></th>";
                while($field = $data_result->fetch_field()) {
                    echo "<th>{$field->name}</th>"; // Mostrar nombres de los campos
                }
                echo "</tr></thead>";
                echo "<tbody>";

                // Mostrar todos los datos con checkboxes para selección
                $data_result->data_seek(0); // Reiniciar el puntero de resultados
                while($row = $data_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='selected_rows[]' value='".htmlspecialchars(json_encode($row), ENT_QUOTES)."'></td>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
                echo "<input type='submit' class='btn btn-primary' name='confirm_selection' value='Confirmar Selección'>";
                echo "</form>";

                // Procesamiento de la selección
                if (isset($_POST['confirm_selection'])) {
                    if (!empty($_POST['selected_rows'])) {
                        $selected_data = $_POST['selected_rows'];
                        $selected_table = $_GET['tabla'];
                        $json_file = 'selected_data.json';
                        file_put_contents($json_file, json_encode($selected_data));
                        
                        // Leer y mostrar los datos seleccionados del archivo JSON
                        $selected_rows_decoded = array_map('json_decode', $selected_data);
                        echo "<h2 class='mt-5 mb-4'>Datos Seleccionados</h2>";
                        echo "<form action='procesar_datos.php' method='post'>";
                        echo "<input type='hidden' name='selected_table' value='$selected_table'>";
                        echo "<input type='hidden' name='usuariopr' value='$usuariopr'>";
        
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-striped table-bordered'>";
                        echo "<thead class='thead-light'><tr>";
                        echo "<th></th>"; // Checkbox de selección
                        foreach ($selected_rows_decoded[0] as $key => $value) {
                            echo "<th>$key</th>"; // Mostrar nombres de los campos
                        }
                        echo "<th>Descuento (%)</th>";
                        echo "<th>Precio</th>";
                        echo "<th>Cantidad</th>";
                        echo "</tr></thead>";
                        echo "<tbody>";

                        foreach ($selected_rows_decoded as $row) {
                            $row = (array)$row;
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='selected_rows[]' value='".htmlspecialchars(json_encode($row), ENT_QUOTES)."' checked></td>";
                            foreach ($row as $key => $value) {
                                echo "<td>$value</td>";
                            }
                            // Verificar si el precio está definido
                            if (isset($row['Precio'])) {
                                echo "<td><input type='text' class='form-control' name='descuento[]' value='0'></td>"; // Agrega un campo para el descuento
                                echo "<td>$row[Precio]</td>"; // Muestra el precio existente
                            } else {
                                echo "<td><input type='text' class='form-control' name='descuento[]' value='0'></td>"; // Agrega un campo para el descuento
                                echo "<td><input type='number' class='form-control' name='precio[]' value='$row[precio]'></td>"; // Agrega un campo para el precio
                            }
                            echo "<td><input type='number' class='form-control' name='cantidad[]' value='1'></td>"; // Agrega un campo para la cantidad
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                        echo "<input type='submit' class='btn btn-primary' name='submit' value='Procesar Seleccionados'>";
                        echo "</form>";
                    } else {
                        echo "No se ha seleccionado ninguna fila.";
                    }
                }
            } else {
                echo "No se encontraron datos en la tabla '$selected_table'.";
            }
            $conn->close();
        } else {
            echo "No se ha seleccionado ninguna tabla.";
        }
        ?>
        <br>
        <a href="s.php" class="btn btn-secondary">Seleccionar Otra Tabla</a>
    </div>
</body>
</html>
