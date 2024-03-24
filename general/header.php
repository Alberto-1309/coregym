<section>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }    
    if (isset($_COOKIE['usuarioLogueado'])) {
        $_SESSION['usuario'] = $_COOKIE['usuarioLogueado'];
    }
    if (isset($_COOKIE['correoUsuario'])) {
        $_SESSION['correo'] = $_COOKIE['correoUsuario'];
    }
    ?>
    <header>
        <div class="logo-titulo">
            <a href="index.php">
                <img src="./img/logo_coregym.png" width="50px" height="50px"/>
            </a>
            <a href="index.php">
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
                    <p>Ya tienes una cuenta? <button id="btnLoginModal">Iniciar sesión</button></p>
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
                <form id="formularioLogin" method="post">
                    <h2>Iniciar Sesión</h2>
                    <input type="email" name="correo" placeholder="Correo" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <div class="sesion_iniciada">
                        <input type="checkbox" name="sesion_iniciada">
                        <label for="sesion_iniciada">Recuérdame</label>
                    </div>
                    <p>¿No tienes una cuenta? <button id="btnRegistrarseModal">Regístrate</button></p>
                    <button type="submit" id="btnformularioLogin">Ingresar</button>
                </form>
            </div>
        </div>
    </header>
</section>
<script>
    //Script del botón de cerrar sesión
    document.addEventListener('DOMContentLoaded', (event) => {
        const btnCerrarSesion = document.getElementById('btnCerrarSesion');
        if (btnCerrarSesion) {
            btnCerrarSesion.addEventListener('click', function(e) {
                e.preventDefault();
                fetch('general/logout.php', {
                    method: 'POST',
                })
                .then(response => {
                    if (response.ok) {
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
    //variables "globales"
    var modalRegistro = document.getElementById("modalRegistro");
    var modalLogin = document.getElementById("modalLogin");
    var btnRegistro = document.getElementById("btnRegistrarse");
    var btnLogin = document.getElementById("btnInicio");
    //Clicks y función de control de botones y ventanas emergentes de login y registro
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
        } else if (event.target == modalPago) {
            modalPago.style.display = "none";
        }
    }
    // Script que controla como se muestran los mensajes de exito y error
    function mostrarMensaje(mensaje, esError = false) {
        var mensajeDiv = document.getElementById('mensaje');
        mensajeDiv.textContent = mensaje;
        mensajeDiv.style.display = 'block';
        mensajeDiv.style.backgroundColor = esError ? '#ffb3b3' : '#fff';
        mensajeDiv.style.color = esError ? '#d8000c' : '#333';
        mensajeDiv.style.borderColor = esError ? '#d8000c' : '#888';
        setTimeout(function() {
            mensajeDiv.style.display = 'none';
        }, 2000);
    }
    // Script que controla el click en el boton Registrarse y Pagar en el modal de Registrarse
    var modalPago = document.getElementById("modalPago");
    document.getElementById('formularioRegistro').addEventListener('submit', function(e) {
        e.preventDefault();
        verificarCorreoYMostrarModal("input[type=email]", modalPago, true);
    });
    // Script que controla la Verificación del correo al darle al botón Registrarse y Pagar del modal de Registrarse
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
    // Script que controla la accion de Registrarse en el modal de pago
    var btnPagarInscribirse = document.getElementById("btnPagarInscribirse");
    btnPagarInscribirse.onclick = function() {
        var datosFormulario = new FormData(document.getElementById('formularioRegistro'));
        registrarDatos(datosFormulario); // Función para registrar los datos y manejar la lógica de pago
    };
    function registrarDatos(datosFormulario) {
        fetch('general/registrar.php', {
            method: 'POST',
            body: datosFormulario
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                mostrarMensaje("Simulación de comunicación con el banco...");
                setTimeout(function() {
                    mostrarMensaje("Pago realizado!");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }, 2000);
            } else {
                mostrarMensaje("Error al realizar el pago. Por favor, intenta de nuevo.", true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje("Error al procesar el pago. Por favor, intenta de nuevo.", true);
        });
    }
    //Script que controla la acción de Login en el modal de login
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formularioLogin').addEventListener('submit', function(e) {
            e.preventDefault();
            var datosFormulario = new FormData(this);
            fetch('general/login.php', {
                method: 'POST',
                body: datosFormulario
            })
            .then(response => response.json())
            .then(data => {
                if (data.exito) {
                    window.location.reload();
                } else {
                    mostrarMensaje("Correo o contraseña incorrecta.", true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje("Error al procesar la solicitud. Por favor, intenta de nuevo.", true);
            });
        });
    });
    //Script para cambiar el precio cada vez que se selecciona una suscripción
    document.addEventListener('DOMContentLoaded', function() {
        const precios = {
            semanal: '11.90€',
            mensual: '35.90€',
            semestral: '195.00€'
        };
        const selectSuscripcion = document.querySelector('[name="suscripcion"]');
        const precioSuscripcion = document.getElementById('precioSuscripcion');
        const actualizarPrecio = () => {
            const cuota = selectSuscripcion.value;
            precioSuscripcion.textContent = precios[cuota] || '';
        };
        selectSuscripcion.addEventListener('change', actualizarPrecio);
        actualizarPrecio();
    });
    //Script de control del boton Registrarse en el modal login
    document.addEventListener('DOMContentLoaded', function() {
        var btnRegistroModal = document.getElementById("btnRegistrarseModal")
        btnRegistroModal.onclick = function() {
            modalLogin.style.display = "none";
            modalRegistro.style.display = "block";
        }
    });
    //Script de control del boton Login en el modal Registrarse
    document.addEventListener('DOMContentLoaded', function() {
        var btnLoginModal = document.getElementById("btnLoginModal")
        btnLoginModal.onclick = function() {
            modalLogin.style.display = "block";
            modalRegistro.style.display = "none";
        }
    });
</script>