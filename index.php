<?php
session_start();

if (isset($_COOKIE['usuarioLogueado'])) {
    // Establecer variables de sesión u otro mecanismo para mantener al usuario logueado
    $_SESSION['usuario'] = $_COOKIE['usuarioLogueado'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coregym</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <!-- CSS FORMULARIOS -->
    <link rel="stylesheet" href="css/formularios.css">
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php'; ?>

    <div id="mensaje" style="display:none;"></div>
    
    <!-- Modal de Registro -->
    <div id="modalRegistro" class="modal">
        <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalRegistro').style.display='none'">&times;</span>
            <form id="formularioRegistro" action="registrar.php" method="post">
                <h2>Inscripción</h2>
                <fieldset>
                    <legend>DATOS PERSONALES</legend>
                    <label>
                        <input type="radio" name="sexo" value="masculino"> Hombre
                    </label>
                    <label>
                        <input type="radio" name="sexo" value="femenino"> Mujer
                    </label>
                    <label>
                        <input type="radio" name="sexo" value="otro"> Otro
                    </label>
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                    <input type="text" name="dni" placeholder="DNI" required>
                    <input type="email" name="correo" placeholder="Correo" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </fieldset>
                <br>
                <fieldset>
                    <legend>FECHA DE NACIMIENTO</legend>
                    <input type="date" name="fecha_nac" required>
                </fieldset>
                <br>
                <fieldset>
                    <legend>MEMBRESÍA</legend>
                    <select name="suscripcion" required>
                        <option value="semanal">Semanal</option>
                        <option value="mensual">Mensual</option>
                        <option value="semestral">Semestral</option>
                    </select>
                </fieldset>
                <br>
                <fieldset>
                    <legend>PESO</legend>
                    <input type="number" step="any" name="peso" placeholder="Peso (kg)" required>
                </fieldset>
                <br>
                <fieldset>
                    <legend>ALTURA</legend>
                    <input type="number" step="any" name="altura" placeholder="Altura (cm)" required>
                </fieldset>
                <br>
                <div class="sesion_iniciada">
                    <input type="checkbox" name="sesion_iniciada">
                    <label for="sesion_iniciada">Mantener sesión iniciada</label>
                </div>
                <br>
                <button id="btnformulario" type="submit">Continuar pago</button>
            </form>
        </div>
    </div>

    <!-- Modal de Pago -->
    <div id="modalPago" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modalPago').style.display='none'">&times;</span>
            <h2>Proceso de Pago</h2>
            <p>Detalles del pago...</p>
            <button id="btnPagarInscribirse">Pagar e Inscribirse</button>
        </div>
    </div>
    <!-- Modal de Login -->
    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modalLogin').style.display='none'">&times;</span>
            <form action="login.php" method="post">
                <h2>Iniciar Sesión</h2>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <div class="sesion_iniciada">
                    <input type="checkbox" name="sesion_iniciada">
                    <label for="sesion_iniciada">Recuérdame</label>
                </div>
                <button id="btnformulario" type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <!-- Inclusión del footer -->
    <?php include './general/footer.php'; ?>

    <script>
        // Ya tienes los manejadores onclick inline en tu HTML que cierran los modales correspondientes.
        var modalRegistro = document.getElementById("modalRegistro");
        var modalLogin = document.getElementById("modalLogin");
        var btnRegistro = document.getElementById("btnRegistrarse");
        var btnLogin = document.getElementById("btnInicio");

        btnRegistro.onclick = function() {
            modalRegistro.style.display = "block";
        }

        btnLogin.onclick = function() {
            modalLogin.style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == modalRegistro) {
                modalRegistro.style.display = "none";
            } else if (event.target == modalLogin) {
                modalLogin.style.display = "none";
            } else if (event.target == modalPago) { // Asegurándose de cerrar el modalPago si se clickea fuera de él.
                modalPago.style.display = "none";
            }
        }
    </script>

    <script>
        var modalPago = document.getElementById("modalPago");
        var btnPagarInscribirse = document.getElementById("btnPagarInscribirse");

        // Manejador del evento submit para el formulario
        document.getElementById('formularioRegistro').addEventListener('submit', function(e) {
            e.preventDefault(); // Previene el envío tradicional del formulario
            verificarCorreoYMostrarModal("input[type=email]", modalPago, true); // Verifica correo y muestra modalPago si es necesario
        });

        btnPagarInscribirse.onclick = function() {
            var datosFormulario = new FormData(document.getElementById('formularioRegistro'));
            registrarDatos(datosFormulario); // Función para registrar los datos y manejar la lógica de pago
        };

        function mostrarMensaje(mensaje, esError = false) {
            var mensajeDiv = document.getElementById('mensaje');
            mensajeDiv.textContent = mensaje;
            mensajeDiv.style.display = 'block';

            //Color de mensaje de error y si no es error color de mensaje de exito
            mensajeDiv.style.backgroundColor = esError ? '#ffb3b3' : '#fff';
            mensajeDiv.style.color = esError ? '#d8000c' : '#333';
            mensajeDiv.style.borderColor = esError ? '#d8000c' : '#888';

            setTimeout(function() {
                mensajeDiv.style.display = 'none';
            }, 2000);
        }
        // Función para verificar correo y opcionalmente mostrar un modal
        function verificarCorreoYMostrarModal(selectorCorreo, modal, esRegistro) {
            var correoInput = document.querySelector(selectorCorreo);
            var correo = correoInput.value;
            
            fetch('verificar_correo.php', {
                method: 'POST',
                body: JSON.stringify({correo: correo}),
                headers: {'Content-Type': 'application/json'}
            })
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    mostrarMensaje("El correo ya está registrado. Por favor, utiliza otro correo.", true);
                    correoInput.style.border = "2px solid red";
                } else {
                    if (esRegistro) {
                        modal.style.display = "block";
                        correoInput.style.border = "1px solid #ccc";
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje("Ocurrió un error al verificar el correo. Inténtalo de nuevo.", true);
            });
        }
        // Función para registrar datos y manejar lógica de pago
        function registrarDatos(datosFormulario) {
            fetch('registrar.php', {
                method: 'POST',
                body: datosFormulario
            })
            .then(response => response.text())
            .then(data => {
                // Manejo de respuesta y lógica de éxito
                mostrarMensaje("Simulación de comunicación con el banco...");

                setTimeout(function() {
                    mostrarMensaje("Pago realizado!");
                    setTimeout(function() {
                        // Recarga la página sin necesidad de ocultar los modales manualmente
                        window.location.reload();
                    }, 2000); // Espera 2 segundos después de mostrar "Pago realizado!"
                }, 2000); // Espera 2 segundos después de "Simulación de comunicación con el banco..."
            })
            .catch(error => {
                console.error('Error:', error);
                // Manejo de error
            });
        }
    </script>
</body>
</html>
