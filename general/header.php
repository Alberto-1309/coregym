<section>
    <?php
    session_start();
    if (isset($_COOKIE['usuarioLogueado'])) {
        // Establecer variables de sesión u otro mecanismo para mantener al usuario logueado
        $_SESSION['usuario'] = $_COOKIE['usuarioLogueado'];
    }
    ?>
    <header>
        <div class="logo-titulo">
            <a href="index.php">
                <img src="./img/logo_coregym.png" width="50px" height="50px"/>
            </a>
            <a href="index.php"> <!-- Enlace para el título -->
                <h1>CoreGym</h1>
            </a>
        </div>
        <nav>
            <a href="donde-estamos.php">Donde estamos</a>
            <a href="actividades.php">Actividades</a>
            <a href="cuotas.php">Cuotas</a>
            <a href="sobre-nosotros.php">+Sobre nosotros</a>
            <a href="contacto.php">Contacto</a>
            <?php if(isset($_SESSION['usuario'])): ?>
                <a href="mis_clases.php">Mis clases</a>
                <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                    <form action="logout.php" method="post" style="display: inline;">
                        <button type="submit" id="btnCerrarSesion" style="cursor: pointer;">Cerrar Sesión</button>
                    </form>
            <?php else: ?>
                <button id="btnRegistrarse">INSCRÍBETE</button>
                <button id="btnInicio">MI CUENTA</button>
            <?php endif; ?>
        </nav>
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
                        <div class="selector">
                            <select name="suscripcion" required>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                                <option value="semestral">Semestral</option>
                            </select>
                        </div>
                        <span id="precioSuscripcion"></span>
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
                <form id="formularioLogin" method="post"> <!-- Asegúrate de que el ID esté aquí -->
                    <h2>Iniciar Sesión</h2>
                    <input type="email" name="correo" placeholder="Correo" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <div class="sesion_iniciada">
                        <input type="checkbox" name="sesion_iniciada">
                        <label for="sesion_iniciada">Recuérdame</label>
                    </div>
                    <button type="submit" id="btnformularioLogin">Ingresar</button>
                </form>
            </div>
        </div>
    </header>
</section>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const btnCerrarSesion = document.getElementById('btnCerrarSesion');
        if (btnCerrarSesion) {
            btnCerrarSesion.addEventListener('click', function(e) {
                e.preventDefault();      
                // Realiza una solicitud AJAX para cerrar sesión
                fetch('general/logout.php', {
                    method: 'POST',
                    // Agrega cualquier encabezado o cuerpo necesario para tu solicitud
                })
                .then(response => {
                    if (response.ok) {
                        // Recarga la página después de cerrar sesión
                        window.location.reload();
                    } else {
                        alert('La sesión no se pudo cerrar correctamente.');
                    }
                })
                .catch(error => {
                    console.error('Error al cerrar sesión:', error);
                });
            });
        }
    });
</script>
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
        fetch('general/verificar_correo.php', {
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
        fetch('general/registrar.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.json()) // Asegúrate de que registrar.php envía una respuesta JSON
        .then(data => {
            if (data.exito) {
                // Manejo de respuesta de éxito
                mostrarMensaje("Simulación de comunicación con el banco...");
                setTimeout(function() {
                    // Aquí podrías redirigir al usuario a otra página o realizar alguna otra acción
                    mostrarMensaje("Pago realizado!");
                    setTimeout(function() {
                        // Recarga la página sin necesidad de ocultar los modales manualmente
                        window.location.reload();
                    }, 2000); // Espera 2 segundos después de mostrar "Pago realizado!"
                }, 2000); // Espera 2 segundos después de mostrar mensaje de éxito de registro
            } else {
                // Manejo de respuesta de error
                mostrarMensaje("Error al realizar el pago. Por favor, intenta de nuevo.", true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje("Error al procesar el pago. Por favor, intenta de nuevo.", true);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formularioLogin').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario
            var datosFormulario = new FormData(this); // 'this' se refiere al formulario
            fetch('general/login.php', {
                method: 'POST',
                body: datosFormulario
            })
            .then(response => response.json())
            .then(data => {
                if (data.exito) {
                    // Login exitoso, recargar la página
                    window.location.reload();
                } else {
                    // Mostrar mensaje de error
                    mostrarMensaje(data.mensaje, true); // Asegúrate de tener una función para mostrar mensajes
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje("Error al procesar la solicitud. Por favor, intenta de nuevo.", true);
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        // Evento para cambiar el precio cada vez que se selecciona una nueva suscripción
        selectSuscripcion.addEventListener('change', actualizarPrecio);
        // Actualizar el precio inicial al cargar la página
        actualizarPrecio();
    });
</script>