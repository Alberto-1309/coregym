<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coregym</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .cuota {
            background: #fff;
            margin: 1em;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .cuota h2 {
            color: #333;
            font-size: 1.5em;
            margin-top: 0;
        }
        .cuota button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.75em 1.5em;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
            margin-top: 1em;
            display: block;
        }
        .cuota button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php';?>
    <div class="cuerpo">
        <!-- Asumiendo que tienes una sección como esta para cada cuota -->
        <div class="cuota">
            <h2>CUOTA SEMESTRAL</h2>
            <ul>
                <li>Acceso a Sala, Clases y matrícula</li>
                <li>Incluye valoración física de entrenamiento personal</li>
                <li>Sin permanencia</li>
                <li>Renovación cuota semestral (195.00€)</li>
                <li>Cuota promocional bajo domiciliación</li>
            </ul>
            <button class="btnApuntarse" data-cuota="semestral">¡ME APUNTO!</button>
        </div>
        <div class="cuota">
            <h2>CUOTA MENSUAL</h2>
            <ul>
                <li>Acceso a Sala, Clases y matrícula</li>
                <li>Incluye valoración física de entrenamiento personal</li>
                <li>Sin permanencia</li>
                <li>Renovación cuota mensual (35.90€)</li>
                <li>Cuota promocional bajo domiciliación</li>
            </ul>
            <button class="btnApuntarse" data-cuota="mensual">¡ME APUNTO!</button>
        </div>
        <div class="cuota">
            <h2>CUOTA SEMANAL</h2>
            <ul>
                <li>Acceso a Sala, Clases y matrícula</li>
                <li>Incluye valoración física de entrenamiento personal</li>
                <li>Sin permanencia</li>
                <li>Renovación cuota semanal (11.90€)</li>
                <li>Cuota promocional bajo domiciliación</li>
            </ul>
            <button class="btnApuntarse" data-cuota="semanal">¡ME APUNTO!</button>
        </div>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar evento click a cada botón de ¡ME APUNTO!
            document.querySelectorAll('.btnApuntarse').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    // Aquí podrías establecer el tipo de cuota seleccionado, por ejemplo:
                    var tipoDeCuota = this.getAttribute('data-cuota');
                    // Suponiendo que tu formulario tenga un campo para el tipo de cuota:
                    var campoCuota = document.querySelector('#formularioRegistro [name="suscripcion"]');
                    if(campoCuota) {
                        campoCuota.value = tipoDeCuota;
                    }
                    // Mostrar el modal de registro
                    document.getElementById('modalRegistro').style.display = 'block';
                });
            });
        });
    </script>
</body>
</html>
