<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Categoría</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .campo-wrapper {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
    <script>
        // Función para agregar dinámicamente un nuevo campo
        function agregarCampo() {
            var wrapper = document.getElementById("campos-wrapper");
            var nuevoCampo = document.createElement("div");
            nuevoCampo.innerHTML = '<div class="form-group campo-wrapper"><label>Nombre del Campo:</label><input type="text" class="form-control" name="nombres_campos[]" required><label>Tipo de Campo:</label><select class="form-control" name="tipos_campos[]"><option value="VARCHAR">Texto</option><option value="INT">Numérico</option></select></div>';
            wrapper.appendChild(nuevoCampo);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Agregar Nueva Categoría</h1>
        <form action="addcat_process.php" method="POST">
            <div class="form-group">
                <label for="categoria">Nombre de la Categoría:</label>
                <input type="text" id="categoria" class="form-control" name="categoria" required>
            </div>
            <div id="campos-wrapper">
                <div class="form-group campo-wrapper">
                    <label>Nombre del Campo:</label>
                    <input type="text" class="form-control" name="nombres_campos[]" required>
                    <label>Tipo de Campo:</label>
                    <select class="form-control" name="tipos_campos[]">
                        <option value="VARCHAR">Texto</option>
                        <option value="INT">Numérico</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="agregarCampo()">Agregar Campo</button>
            <input type="submit" class="btn btn-success" value="Agregar Categoría">
        </form>
    </div>
</body>
</html>

