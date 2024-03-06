<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coregym</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
        }
        header { 
            background-color: #f3f3f3;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center; 
        }
        nav a, nav button { 
            margin: 0 10px; 
            text-decoration: none; 
            color: #000; 
            background-color: transparent;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centra el modal */
            padding: 20px;
            border: 1px solid #888;
            width: 30%; /* Ajuste para mejor visualización */
        }
        .close { 
            color: #aaa; 
            float: right; 
            font-size: 28px; 
            font-weight: bold; 
        }
        .close:hover, .close:focus { 
            color: black; 
            text-decoration: none; 
            cursor: pointer; 
        }
        input[type=text], input[type=email], input[type=password] { 
            width: 100%; 
            padding: 12px 20px; 
            margin: 8px 0; 
            display: inline-block; 
            border: 1px solid #ccc; 
            box-sizing: border-box; 
        }
        button[type=submit] { 
            background-color: #4CAF50; 
            color: white; 
            padding: 14px 20px; 
            margin: 8px 0; 
            border: none; 
            cursor: pointer; 
            width: 100%; 
        }
        #btnRegistrarse {
            background-color: #4CAF50; /* Verde */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        #btnInicio {
            background-color: #FF0000; /* Rojo */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        #btnRegistrarse:hover {
            background-color: #45a049;
        }
        #btnInicio:hover {
            background-color: #b81414;
        }
        .recuerdame {
            display: flex;
            align-items: center;
        }
        .recuerdame label {
            margin-left: 10px;
            font-size: 14px;
        }
        #mensajeExito {
            position: fixed; /* o absolute, según tu necesidad */
            top: 20px; /* Ajusta según necesites */
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50; /* Verde */
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none; /* Esto se mantiene para que inicialmente esté oculto */
            z-index: 100; /* Asegura que esté sobre otros elementos */
        }

    </style>
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php'; ?>

    <div id="mensajeExito" style="display:none;"></div>
    <!-- Modal de Registro -->
    <div id="modalRegistro" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="formularioRegistro" action="registrar.php" method="post">
                <h2>Inscripción</h2>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="apellido" placeholder="Apellido" required>
                <input type="text" name="dni" placeholder="DNI" required>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <div>
                    <!-- Fecha de nacimiento -->
                    <label for="fecha_nac">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nac" required>
                </div>
                <div>
                    <!-- Opciones de suscripción -->
                    <label for="suscripcion">Suscripción:</label>
                    <select name="suscripcion" required>
                        <option value="semanal">Semanal</option>
                        <option value="mensual">Mensual</option>
                        <option value="semestral">Semestral</option>
                    </select>
                </div>
                <div>
                     <!-- Peso (opcional) -->
                    <label for="peso">Peso (kg): (opcional)</label>
                    <input type="number" step="any" name="peso" placeholder="Peso (kg)">
                </div>
                <div>
                    <!-- Altura (opcional) -->
                    <label for="altura">Altura (cm): (opcional)</label>
                    <input type="number" step="any" name="altura" placeholder="Altura (cm)">
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Login -->
    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modalLogin').style.display='none'">&times;</span>
            <form action="login.php" method="post">
                <h2>Iniciar Sesión</h2>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <div class="recuerdame">
                    <input type="checkbox" name="recuerdame">
                    <label for="recuerdame">Recuérdame</label>
                </div>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>

    <script>
        var modalRegistro = document.getElementById("modalRegistro");
        var modalLogin = document.getElementById("modalLogin");
        var btnRegistro = document.getElementById("btnRegistrarse");
        var btnLogin = document.getElementById("btnInicio");
        var span = document.getElementsByClassName("close");

        btnRegistro.onclick = function() {
            modalRegistro.style.display = "block";
        }

        btnLogin.onclick = function() {
            modalLogin.style.display = "block";
        }

        for (var i = 0; i < span.length; i++) {
            span[i].onclick = function() {
                modalRegistro.style.display = "none";
                modalLogin.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == modalRegistro) {
                modalRegistro.style.display = "none";
            } else if (event.target == modalLogin) {
                modalLogin.style.display = "none";
            }
        }
    </script>
    <script>
        document.getElementById('formularioRegistro').addEventListener('submit', function(e) {
            e.preventDefault(); // Evita el envío tradicional del formulario

            var datosFormulario = new FormData(this);

            fetch('registrar.php', {
                method: 'POST',
                body: datosFormulario
            })
            .then(response => response.text())
            .then(data => {
                // Cierra el modal de registro
                document.getElementById('modalRegistro').style.display = 'none';

                // Muestra el mensaje de éxito
                var mensajeExito = document.getElementById('mensajeExito');
                mensajeExito.style.display = 'block';
                mensajeExito.textContent = data; // Suponiendo que el mensaje de "Registro completado exitosamente" se envía desde el servidor

                // Oculta el mensaje después de 3 segundos
                setTimeout(function() {
                    mensajeExito.style.display = 'none';
                }, 3000);

                // Aquí podrías redirigir al usuario a otra página o iniciar sesión automáticamente
                // Por ejemplo, si tienes una página 'inicioUsuario.php' donde los usuarios van después de iniciar sesión
                // window.location.href = 'inicioUsuario.php';
            })
            .catch(error => console.error('Error:', error));
        });
        </script>
</body>
</html>
