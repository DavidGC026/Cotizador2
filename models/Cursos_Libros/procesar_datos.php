<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../cliente2.php");
    exit();
    }

$usuario = $_SESSION['usuario'];
$usuario1 = $usuario;


$usuariopr = $_POST['usuariopr'];
$selected_table = $_POST['selected_table'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Datos - IMCYC</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Datos Procesados - IMCYC Usuario: <?php echo $usuariopr?></h2>
        <?php
        if(isset($_POST['selected_rows']) && isset($_POST['descuento']) && isset($_POST['cantidad']) && isset($_POST['precio'])) {
            $selected_rows = $_POST['selected_rows'];
            $selected_rows = array_map('json_decode', $selected_rows);

            $descuentos = $_POST['descuento'];
            $cantidades = $_POST['cantidad'];
            $precios = $_POST['precio'];
            
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr>";
            echo "<th></th>";
            foreach ($selected_rows[0] as $key => $value) {
                echo "<th>$key</th>";
            }
            echo "<th>Descuento (%)</th>";
            echo "<th>Cantidad</th>";
            echo "<th>Precio</th>";
            echo "<th>Subtotal</th>";
            echo "</tr></thead>";
            echo "<tbody>";

            $total = 0;

            foreach ($selected_rows as $index => $row) {
                echo "<tr>";
                echo "<td><input type='checkbox' disabled checked></td>";
                foreach ($row as $key => $value) {
                    echo "<td>$value</td>";
                }
                echo "<td>" . $descuentos[$index] . "</td>";
                echo "<td>" . $cantidades[$index] . "</td>";
                echo "<td>" . $precios[$index] . "</td>";
                $subtotal = $precios[$index] * $cantidades[$index] * (1 - ($descuentos[$index] / 100));
                $total += $subtotal;
                echo "<td>" . number_format($subtotal, 2) . "</td>";
                echo "</tr>";
            }

            $iva = $total * 0.16; // Suponiendo que el IVA es del 16%
            $total_con_iva = $total + $iva;

            echo "</tbody></table></div>";
            echo "<h4>Total: $" . number_format($total, 2) . "</h4>";
            echo "<h4>IVA (16%): $" . number_format($iva, 2) . "</h4>";
            echo "<h4>Total con IVA: $" . number_format($total_con_iva, 2) . "</h4>";
            echo "<h4>Nombre Cliente:" . $usuario1 . "</h4>";

            echo "<form action='generar_factura4.php' method='post'>";
            echo "<input type='hidden' name='usuariopr' value='" . $usuariopr . "'>";
            echo "<input type='hidden' name='usuario' value='" . $usuario1 . "'>";
            echo "<input type='hidden' name='selected_table' value='" . $selected_table . "'>";
            echo "<input type='hidden' name='selected_rows' value='" . htmlspecialchars(json_encode($selected_rows), ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='descuento' value='" . htmlspecialchars(json_encode($descuentos), ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='cantidad' value='" . htmlspecialchars(json_encode($cantidades), ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='precio' value='" . htmlspecialchars(json_encode($precios), ENT_QUOTES) . "'>";
            echo "<button type='submit' class='btn btn-primary'>Generar PDF</button>";
            echo "</form>";
        } else {
            echo "No se han seleccionado datos para procesar.";
        }
        ?>
        <br>
        <a href="s.php" class="btn btn-primary">Volver a Seleccionar Tabla</a>
    </div>
</body>
</html>
