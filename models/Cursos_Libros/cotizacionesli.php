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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización de Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
    <style>
        .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #333;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .menu li {
            text-align: center;
            border-bottom: 1px solid #555; /* Línea de separación entre elementos */
        }

        .menu li:last-child {
            border-bottom: none; /* Elimina la línea de separación del último elemento */
        }

        .menu li a {
            display: block;
            color: white;
            padding: 14px 16px;
            text-decoration: none;
        }

        .menu li a:hover {
            background-color: #555; /* Cambio de color de fondo en hover */
        }

        /* Estilos CSS para el iframe */
        iframe {
            margin-left: 200px; /* Para dejar espacio al lado del menú */
            width: calc(100% - 200px); /* Ajusta el ancho del iframe */
            height: 80vh; /* Altura del 80% del viewport */
            border: none;
            overflow-y: auto; /* Agrega scroll vertical si el contenido es demasiado largo */
        }

        /* Estilos CSS restantes */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Cambio de fuente */
            background-color: #f2f2f2; /* Cambio de color de fondo */
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .container {
            max-width: 1020px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #555; /* Cambio de color de fondo */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ddd; /* Cambio de color de fondo */
        }

        canvas {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <h1>Cotizaciones Libros y Cursos <?php echo $usuariopr ?></h1>

    <ul class="menu">
        <li><a href="libros.php?usuariopr=<?php  echo urlencode($usuariopr); ?>" target="iframeCotizaciones">Libros</a></li>
        <li><a href="cursos.php?usuariopr=<?php  echo urlencode($usuariopr); ?>" target="iframeCotizaciones">Cursos</a></li>
        <li><a href="webinars.php?usuariopr=<?php  echo urlencode($usuariopr); ?>" target="iframeCotizaciones">Webinars</a></li>
        <li><a href="s.php?usuariopr=<?php  echo urlencode($usuariopr); ?>" target="iframeCotizaciones">Mas Categorias</a></li>
        <li><a href="addcat.php?usuariopr=<?php echo urlencode($usuariopr); ?>" target="iframeCotizaciones">Agregar Categoria</a></li>
        <li><a href="addpr.php?usuariopr=<?php echo urlencode($usuariopr); ?>"  target="iframeCotizaciones">Agregar Producto</a></li>

    </ul>

    <iframe name="iframeCotizaciones" src="libros.php?usuariopr=<?php  echo urlencode($usuariopr);?>" frameborder="0"></iframe>
</body>
</html>
