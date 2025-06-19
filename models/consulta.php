<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos específicos */

        .container {
            margin-top: 20px;
        }

        .btn-primary {
            background-color: #001f3f;
            border: none;
        }

        .btn-primary:hover {
            background-color: #001a35;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .total {
            margin-top: 20px;
        }
    /* Estilos generales */

    body {
        font-family: 'Arial', sans-serif;
        margin: 20px;
        background-color: #f2f2f2;
        color: #333;
    }

    h1 {
        font-size: 1.5em;
    }

    h2 {
        color: #001f3f;
    }

    label {
        font-weight: bold;
        margin-right: 10px;
    }

    input,
    button {
        padding: 8px;
        margin-right: 10px;
    }

    button {
        padding: 10px;
        background-color: #001f3f;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #001f3f;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #ddd;
    }

    .total {
        margin-top: 20px;
    }

    /* Estilos para dispositivos móviles */

    @media only screen and (max-width: 600px) {
        body {
            margin: 10px;
        }

        h1 {
            font-size: 1.2em;
        }

        h2 {
            font-size: 1em;
        }

        label {
            font-size: 0.8em;
        }

        input,
        button {
            padding: 6px;
        }

        table {
            font-size: 0.8em;
        }

        th, td {
            padding: 8px;
        }

        iframe {
            width: 100%;
            height: 300px; /* Ajustar la altura del iframe según sea necesario */
        }
    }

    /* Estilos para pantallas medianas */

    @media only screen and (min-width: 601px) and (max-width: 1024px) {
        body {
            margin: 30px;
        }

        h1 {
            font-size: 1.8em;
        }

        h2 {
            font-size: 1.5em;
        }

        table {
            font-size: 1em;
        }

        th, td {
            padding: 12px;
        }
    }
    </style>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "admin";
    $password = "Imc590923cz4#";
    $dbname = "mysql";

    require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: cliente.php");
        exit();
    }

    $usuario = $_SESSION['usuario'];
    $usuario1 = $usuario;


    $usuariopr = $_GET['usuariopr'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $sql_general = "SELECT * FROM articulos";
    $result_general = $conn->query($sql_general);

    if ($result_general->num_rows > 0) {
        while ($row = $result_general->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $data = [];
    }

    $sql_cliente = "SELECT id, usuario FROM clientes WHERE usuario = ?";
    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $usuario1);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();

    $cliente_data = $result_cliente->fetch_assoc();

    $conn->close();
    ?>
    <div class="container">
        <h1>Generando Cotización para <?php echo $usuario ?></h1>
        <h2>Consulta de Datos</h2>
        <div class="form-group">
        <label for="idInput" style="display: block;" id="idLabel">ID:</label>
            <input type="text" id="idInput" class="form-control">
        </div>
        <button id="consultarPorId" class="btn btn-primary">Consultar por ID</button>

        <br><br>

        <table id="dataTable" class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Numero_Articulo</th>
                    <th>Descripcion</th>
                    <th>Precio_Venta</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Total Final</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    $id = $row['id'];
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['Numero_Articulo']}</td>";
                    echo "<td>{$row['Descripcion']}</td>";
                    if ($row['Precio_Venta'] == 0) {
                        echo "<td><input type='number' name='precioVenta[$id]' class='precioVenta' value=''></td>";
                    } else {
                        echo "<td><input type='number' name='precioVenta[$id]' class='precioVenta' value='{$row['Precio_Venta']}'></td>";
                    }
                    echo "<td><input type='number' class='cantidad' min='1' max='10'></td>";
                    echo "<td><input type='number' class='descuento' min='1' max='100'></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td><input type='checkbox' class='seleccion' data-precio='{$row['Precio_Venta']}'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <table>
        <tr>
            <td>
                <button id="continuar" style="background-color: #001f3f;" style="display: block">Continuar</button>
                <button type="submit" name="regresar" id="regresar" style="display: none; background-color: #001f3f;">Regresar</button>
            </td>
            <td>
                <form method="post" action="generar_pdf.php" id="pdfForm" target="_blank">
                    <table border="0px">
                        <tr>
                            <td><label id="duracionPruebatxt" style="display: none";>Duración de la prueba:</label></td>
                            <td><input type="text" id="duracionPrueba" name="duracionPrueba" style="display: none";></td>
                            <td>
                                <button type="submit" name="generarPDF" id="enviarPDF" style="display: none; background-color: #001f3f;">Enviar PDF</button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                    <input type="hidden" id="costoTotal" name="costoTotal" value="">
                    <input type="hidden" id="descuento1" name="descuento1" value="">
                    <input type="hidden" name="usuariopr" value="<?php echo $usuariopr; ?>">
                    <input type="hidden" name="usuario_id" value="<?php echo $cliente_data['id']; ?>">
                    <input type="hidden" id="datosTabla" name="datosTabla" value="">
                </form>
            </td>
        </tr>
    </table>

        <div class="total" id="totalContainer" style="display: none;">
            Subtotal: <span id="subtotal">0</span><br>
            IVA (16%): <span id="iva">0</span><br>
            Precio Total (con IVA): <span id="precioTotalFinal">0</span>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var datos = <?php echo json_encode($data); ?>;
        var checkboxesState = JSON.parse(localStorage.getItem('checkboxesState')) || {};
        var descuentoValues = JSON.parse(localStorage.getItem('descuentoValues')) || {};
        var cantidadValues = JSON.parse(localStorage.getItem('cantidadValues')) || {};
        var precioVentaValues = JSON.parse(localStorage.getItem('precioVentaValues')) || {};
        savePrecioVentaValues();

        function savePrecioVentaValues() {
            var precioVentaInputs = document.getElementsByClassName('precioVenta');

            for (var i = 0; i < precioVentaInputs.length; i++) {
                var id = precioVentaInputs[i].parentNode.parentNode.cells[0].textContent;
                var value = precioVentaInputs[i].value;
                precioVentaValues[id] = value;
            }

            localStorage.setItem('precioVentaValues', JSON.stringify(precioVentaValues));
        }

        function restorePrecioVentaValue() {
            var precioVentaInputs = document.getElementsByClassName('precioVenta');

            for (var i = 0; i < precioVentaInputs.length; i++) {
                var id = precioVentaInputs[i].parentNode.parentNode.cells[0].textContent;
                var storedValue = precioVentaValues[id];

                if (storedValue !== undefined) {
            precioVentaInputs[i].value = storedValue;
                }
            }
        }

        function saveDescuentoValues() {
            var descuentoInputs = document.getElementsByClassName('descuento');

            for (var i = 0; i < descuentoInputs.length; i++) {
                var id = descuentoInputs[i].parentNode.parentNode.cells[0].textContent;
                var value = descuentoInputs[i].value;
                descuentoValues[id] = value;
            }

            localStorage.setItem('descuentoValues', JSON.stringify(descuentoValues));
        }

        function restoreDescuentoValue() {
            var descuentoInputs = document.getElementsByClassName('descuento');

            for (var i = 0; i < descuentoInputs.length; i++) {
                var id = descuentoInputs[i].parentNode.parentNode.cells[0].textContent;
                var storedValue = descuentoValues[id];

                if (storedValue !== undefined) {
                    descuentoInputs[i].value = storedValue;
                }
            }
        }

        function mostrarBotones() {
            document.getElementById("enviarPDF").style.display = "block";
            document.getElementById("regresar").style.display = "block";
            document.getElementById("duracionPrueba").style.display = "block";
            document.getElementById("duracionPruebatxt").style.display = "block";
            document.getElementById("continuar").style.display = "none";
            document.getElementById("idInput").style.display = "none";
            document.getElementById("consultarPorId").style.display = "none";
            document.getElementById("idLabel").style.display = "none";
            document.getElementById("totalContainer").style.display = "block";
        }

        function mostrarConsultarPorId() {
            document.getElementById("enviarPDF").style.display = "none";
            document.getElementById("regresar").style.display = "none";
            document.getElementById("totalContainer").style.display = "none";
            document.getElementById("duracionPrueba").style.display = "none";
            document.getElementById("duracionPruebatxt").style.display = "none";
            document.getElementById("continuar").style.display = "block";
            document.getElementById("idInput").style.display = "block";
            document.getElementById("consultarPorId").style.display = "block";
            document.getElementById("idLabel").style.display = "block";
        }

        function mostrarConsultas() {
            document.getElementById("enviarPDF").style.display = "none";
            document.getElementById("regresar").style.display = "block";
            document.getElementById("totalContainer").style.display = "none";
            document.getElementById("duracionPrueba").style.display = "none";
            document.getElementById("duracionPruebatxt").style.display = "none";
            document.getElementById("continuar").style.display = "none";
            document.getElementById("idInput").style.display = "block";
            document.getElementById("consultarPorId").style.display = "block";
            document.getElementById("idLabel").style.display = "block";
        }

        function consultarPorId() {
            saveCantidadValues();
            saveDescuentoValues();
            saveCheckboxState();
            var idInput = document.getElementById('idInput').value;
            var resultado = datos.find(item => item.id == idInput);

            if (resultado) {
                mostrarResultado([resultado]);
                restoreCantidadValue();
                restorePrecioVentaValue();
                restoreDescuentoValue();
                restoreCheckboxState();
            } else {
                alert('No se encontraron resultados para el ID proporcionado.');
            }
           mostrarConsultas();
        }

        function consultarGeneral() {
            saveCantidadValues();
            savePrecioVentaValues();
            saveCheckboxState();
            saveDescuentoValues();
            mostrarResultado(datos);
            restoreCheckboxState();
            restoreDescuentoValue();
            restoreCantidadValue();
            restorePrecioVentaValue();
            mostrarConsultarPorId();
        }


        function mostrarResultado(data) {
            var table = document.getElementById('dataTable');
            table.innerHTML = '<tr><th>ID</th><th>Numero_Articulo</th><th>Descripcion</th><th>Precio_Venta</th><th>Cantidad</th><th>Descuento</th><th>Total</th><th>Total con Descuento</th><th>Seleccionar</th></tr>';

            data.forEach(item => {
                var row = table.insertRow();
                var idCell = row.insertCell(0);
                var campo1Cell = row.insertCell(1);
                var campo2Cell = row.insertCell(2);
                var campo3Cell = row.insertCell(3);
                var cantidadCell = row.insertCell(4);
                var descuentoCell = row.insertCell(5);
                var totalCell = row.insertCell(6);
                var totalDescCell = row.insertCell(7);
                var checkboxCell = row.insertCell(8);

                idCell.textContent = item.id;
                campo1Cell.textContent = item.Numero_Articulo;
                campo2Cell.textContent = item.Descripcion;
                campo3Cell.innerHTML = `<input type='number' class='precioVenta'>`;
                cantidadCell.innerHTML = `<input type='number' class='cantidad' min='1' max='10'>`;
                descuentoCell.innerHTML = `<input type='number' class='descuento' min='1' max='100'>`;
                totalCell.textContent = '';
                totalDescCell.textContent = '';
                checkboxCell.innerHTML = `<input type='checkbox' class='seleccion' data-precio='${item.Precio_Venta}' ${getCheckboxState(item.id)}>`;
            });
        }

        function actualizarTabla() {
    var checkboxes = document.getElementsByClassName('seleccion');
    var filasSeleccionadas = [];

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            var fila = checkboxes[i].parentNode.parentNode;
            var cantidadInput = fila.getElementsByClassName('cantidad')[0];
            var descuentoInput = fila.getElementsByClassName('descuento')[0];
            var precioVenta1 = fila.getElementsByClassName('precioVenta')[0];
            var totalCell = fila.cells[6];
            var totalDescCell = fila.cells[7];

            var subtotal = parseFloat(cantidadInput.value) * parseFloat(precioVenta1.value);

            totalCell.textContent = (parseFloat(cantidadInput.value) * parseFloat(precioVenta1.value)).toFixed(2);

            if (descuentoInput.value.trim() !== '') {
                var discount = parseFloat(descuentoInput.value);
                var totalWithDiscount = subtotal - ((subtotal * discount) / 100);
                totalDescCell.textContent = totalWithDiscount.toFixed(2);
            } else {
                totalDescCell.textContent = subtotal.toFixed(2);
            }
            filasSeleccionadas.push(fila.cloneNode(true));
        }
    }

    var table = document.getElementById('dataTable');
    table.innerHTML = '<tr><th>ID</th><th>Numero_Articulo</th><th>Descripcion</th><th>Precio_Venta</th><th>Cantidad</th><th>Descuento</th><th>Total</th><th>Total con Descuento</th><th>Seleccionar</th></tr>';

    filasSeleccionadas.forEach(fila => {
        table.appendChild(fila);
    });


    saveCheckboxState();
    saveDescuentoValues();
    saveCantidadValues();
    calcularPrecioTotal();
    document.getElementById('datosTabla').value = JSON.stringify(obtenerDatosTabla());
    mostrarBotones();
}



        function calcularPrecioTotal() {
            var checkboxes = document.getElementsByClassName('seleccion');
            var subtotal = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    subtotal += parseFloat(checkboxes[i].parentNode.parentNode.cells[7].textContent);
                }
            }

            var iva = subtotal * 0.16;
            var precioTotalFinal = subtotal + iva;

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('iva').textContent = iva.toFixed(2);
            document.getElementById('precioTotalFinal').textContent = precioTotalFinal.toFixed(2);

            var costoTotalInput = document.getElementById('costoTotal');
            var valdescuento = document.getElementById('Descuento1');

            costoTotalInput.value = subtotal.toFixed(2);
        }

        function getCheckboxState(id) {
            return checkboxesState[id] ? 'checked' : '';
        }

        function saveCheckboxState() {
            var checkboxes = document.getElementsByClassName('seleccion');

            for (var i = 0; i < checkboxes.length; i++) {
                var id = checkboxes[i].parentNode.parentNode.cells[0].textContent;
                checkboxesState[id] = checkboxes[i].checked;
            }

            localStorage.setItem('checkboxesState', JSON.stringify(checkboxesState));
        }

        function restoreCheckboxState() {
            var checkboxes = document.getElementsByClassName('seleccion');

            for (var i = 0; i < checkboxes.length; i++) {
                var id = checkboxes[i].parentNode.parentNode.cells[0].textContent;
                checkboxes[i].checked = checkboxesState[id] || false;
            }
        }

        function saveCantidadValues() {
            var cantidadInputs = document.getElementsByClassName('cantidad');

            for (var i = 0; i < cantidadInputs.length; i++) {
                var id = cantidadInputs[i].parentNode.parentNode.cells[0].textContent;
                var value = cantidadInputs[i].value;
                cantidadValues[id] = value;
            }

            localStorage.setItem('cantidadValues', JSON.stringify(cantidadValues));
        }

        function restoreCantidadValue() {
            var cantidadInputs = document.getElementsByClassName('cantidad');

            for (var i = 0; i < cantidadInputs.length; i++) {
                var id = cantidadInputs[i].parentNode.parentNode.cells[0].textContent;
                var storedValue = cantidadValues[id];

                if (storedValue !== undefined) {
                    cantidadInputs[i].value = storedValue;
                }
            }
        }

        function obtenerDatosTabla() {
            var datosTabla = [];
            var table = document.getElementById('dataTable');

            for (var i = 1; i < table.rows.length; i++) {
                var row = table.rows[i];
                var id = row.cells[0].textContent;
                var numeroArticulo = row.cells[1].textContent;
                var descripcion = row.cells[2].textContent;
                var precioVenta = row.cells[3].querySelector('.precioVenta').value;
                var cantidad = row.cells[4].querySelector('.cantidad').value;
                var descuento = row.cells[5].querySelector('.descuento').value;
                var total = row.cells[6].textContent;
                var totalDesc = row.cells[7].textContent;
                var seleccionado = row.cells[8].querySelector('.seleccion').checked;

                datosTabla.push({
                    id: id,
                    numeroArticulo: numeroArticulo,
                    descripcion: descripcion,
                    precioVenta: precioVenta,
                    cantidad: cantidad,
                    descuento: descuento,
                    total: total,
                    totalDesc: totalDesc,
                    seleccionado: seleccionado
                });
            }

            return datosTabla;
        }

        document.getElementById("consultarPorId").addEventListener("click", consultarPorId);
        document.getElementById("continuar").addEventListener("click", actualizarTabla);
        document.getElementById("regresar").addEventListener("click", function() {
            consultarGeneral();
            localStorage.removeItem('checkboxesState');
            localStorage.removeItem('descuentoValues');
            localStorage.removeItem('cantidadValues');
            localStorage.removeItem('precioVentaValues');
        });
    </script>
</body>

</html>

