<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuotas</title>
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
            <?php if (isset($_SESSION['usuario'])): ?>
                <button class="btnRenovar" data-cuota="semestral">¡RENOVAR!</button>
            <?php else: ?>
                <button class="btnApuntarse" data-cuota="semestral">¡ME APUNTO!</button>
            <?php endif; ?>        
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
            <?php if (isset($_SESSION['usuario'])): ?>
                <button class="btnRenovar" data-cuota="mensual">¡RENOVAR!</button>
            <?php else: ?>
                <button class="btnApuntarse" data-cuota="mensual">¡ME APUNTO!</button>
            <?php endif; ?>
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
            <?php if (isset($_SESSION['usuario'])): ?>
                <button class="btnRenovar" data-cuota="semanal">¡RENOVAR!</button>
            <?php else: ?>
                <button class="btnApuntarse" data-cuota="semanal">¡ME APUNTO!</button>
            <?php endif; ?>
        </div>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
    <!-- Modal de Renovación -->
    <div id="modalRenovacion" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modalRenovacion').style.display='none'">&times;</span>
            <h2>Renovar Membresía</h2>
            <p>Selecciona la membresía que deseas renovar.</p>
            <form id="formularioRenovacion" onsubmit="event.preventDefault(); renovarMembresia();">
                <fieldset>
                        <legend>MEMBRESÍA</legend>
                        <div class="selector">
                            <select name="tipoCuotaRenovacion" required>
                                <option value="semanal">Semanal - 11.90€</option>
                                <option value="mensual">Mensual - 35.90€</option>
                                <option value="semestral">Semestral - 195.00€</option>
                            </select>
                        </div>
                        <span id="precioSuscripcion"></span>
                    </fieldset>
                <button id="btnformulario" type="submit">Renovar</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnsRenovar = document.querySelectorAll('.btnRenovar');
            btnsRenovar.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tipoCuota = this.getAttribute('data-cuota');
                    document.querySelector('#formularioRenovacion [name="tipoCuotaRenovacion"]').value = tipoCuota;
                    document.getElementById('modalRenovacion').style.display = 'block';
                });
            });
        });
        function renovarMembresia() {
            var formData = new FormData(document.getElementById('formularioRenovacion'));
            fetch('./general/renovar_membresia.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Configurar el mensaje según la respuesta recibida
                mostrarMensaje(data.mensaje, !data.exito);

                if (data.exito) {
                    // Si la operación fue exitosa, opcionalmente puedes recargar la página después de 2 segundos
                    setTimeout(() => window.location.reload(), 2000);
                }
            })
            .catch(error => {
                // Manejar errores de la solicitud fetch, como problemas de red
                console.error('Error:', error);
                mostrarMensaje('Error al procesar la solicitud de renovación.', true);
            });

            // Cierra el modal de renovación inmediatamente después del clic
            document.getElementById('modalRenovacion').style.display = 'none';
        }
        //Script de registro en cuotas
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar evento click a cada botón de ¡ME APUNTO!
            document.querySelectorAll('.btnApuntarse').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var tipoDeCuota = this.getAttribute('data-cuota');
                    var campoCuota = document.querySelector('#formularioRegistro [name="suscripcion"]');
                    if(campoCuota) {
                        campoCuota.value = tipoDeCuota;
                    }
                    const precios = {
                        semanal: '11.90€',
                        mensual: '35.90€',
                        semestral: '195.00€'
                    };
                    const selectSuscripcion = document.querySelector('[name="suscripcion"]');
                    const precioSuscripcion = document.getElementById('precioSuscripcion');
                    // Función para actualizar el precio
                    const actualizarPrecio = () => {
                        const cuota = selectSuscripcion.value;
                        precioSuscripcion.textContent = precios[cuota] || '';
                    };
                    actualizarPrecio();
                    document.getElementById('modalRegistro').style.display = 'block';
                });
            });
        });
    </script>
</body>
</html>
