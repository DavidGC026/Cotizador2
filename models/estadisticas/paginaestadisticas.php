<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Cotizaciones</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        /* Estilos CSS para el menú horizontal */
        ul.menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #007bff;
        }

        ul.menu li {
            float: left;
        }

        ul.menu li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.menu li a:hover {
            background-color: #0056b3;
        }

        /* Estilos CSS para el iframe */
        iframe {
            width: 100%;
            height: 500px; /* Altura ajustable según sea necesario */
            border: none;
        }

        /* Estilos CSS restantes */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1, h2, h3 {
            color: #007bff;
        }

        .container {
            max-width: 10200px;
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
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        iframe {
            width: 100%;
            height: 80%;
            display: block;
            border: none; /* Elimina el borde del iframe */
        }
    </style>
</head>
<body>
    <h1>Estadísticas de Cotizaciones</h1>

    <!-- Menú horizontal para las estadísticas -->
    <ul class="menu">
        <li><a href="estadisticas.php" target="iframeEstadisticas">General</a></li>
        <li><a href="estadisticas_semanales.php" target="iframeEstadisticas">Semanales</a></li>
        <li><a href="estadisticas_mensuales.php" target="iframeEstadisticas">Mensuales</a></li>
        <li><a href="estadisticas_anuales.php" target="iframeEstadisticas">Anuales</a></li>
    </ul>

    <iframe name="iframeEstadisticas" src="estadisticas.php" frameborder="0"></iframe></body>
</html>

