<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            color: #333;
            overflow-x: hidden;
        }

        #menuButton {
            background-color: #001f3f;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 24px;
            transition: 0.3s;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
        }

        #menu {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: -250px;
            background: linear-gradient(gray, 70%, deepskyblue);
            padding-top: 60px;
            transition: 0.3s;
            z-index: 1000;
        }

        #menu a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 25px;
            color: black;
            display: block;
            transition: 0.3s;
        }

        #menu a:hover {
            background: linear-gradient(gray, 60%, white);
            color: black;
        }

        #logo {
            margin-bottom: 20px;
            text-align: center;
        }

        iframe {
            border: none;
            width: 100%;
            height: 100vh;
            transition: opacity .5s ease-in-out;
            opacity: 1;
        }

        iframe.fade-out {
            opacity: 0;
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
    <?php
        $usuariopr = $_GET['usuariopr'];

        $servername = "localhost";
        $username = "admin";
        $password = "Imc590923cz4#";
        $dbname = "mysql";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }

        $sql = "SELECT nombre FROM usuarios WHERE usuariopr = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuariopr);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombreCompleto = $row["nombre"];
        } else {
            $nombreCompleto = "Nombre no encontrado";
        }

        $conn->close();
    ?>
    <button id="menuButton" onclick="toggleSideMenu()">☰</button>
    <div id="menu" class="sidebar">
        <div id="logo">
        <a href="https://www.imcyc.com/">
            <img src="logo.svg" alt="Logo" style="max-width: 300px;"></a>
        </div>
        <a href="inicio.php" onclick="toggleSideMenu()" target="contenido-central">Inicio</a>
        <a href="seleccionarcl.php" onclick="toggleSideMenu()" target="contenido-central">Modificar cliente</a>
        <a href="registro.php" onclick="toggleSideMenu()" target="contenido-central">Agregar Cliente</a>
        <a href="cliente.php?usuariopr=<?php echo urlencode($usuariopr); ?>" onclick="toggleSideMenu()" target="contenido-central">Generar Cotizacion Laboratorio</a>
        <a href="cliente2.php?usuariopr=<?php echo urlencode($usuariopr); ?>" onclick="toggleSideMenu()" target="contenido-central">Generar Cotizacion Libros, Cursos, Webinars, ...</a>
        <a href="ver_cotizaciones.php" onclick="toggleSideMenu()" target="contenido-central">Ver Cotizaciones</a>
        <a href="../index.php">Log-Out</a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <iframe id="contenido-central" name="contenido-central" src="inicio.php"></iframe>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleSideMenu() {
            var menu = document.getElementById("menu");
            var iframe = document.getElementById("contenido-central");
            if (menu.style.left === "0px") {
                menu.style.left = "-250px";
                iframe.classList.remove('fade-out');
            } else {
                menu.style.left = "0px";
                iframe.classList.add('fade-out');
            }
        }

        // Cerrar el menú cuando se hace clic fuera de él
        document.addEventListener('click', function(event) {
            var menu = document.getElementById("menu");
            var menuButton = document.getElementById("menuButton");
            if (event.target !== menu && event.target !== menuButton) {
                menu.style.left = "-250px";
                document.getElementById("contenido-central").classList.remove('fade-out');
            }
        });
    </script>
</body>
</html>

