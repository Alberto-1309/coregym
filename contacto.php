<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Coregym</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <!-- CSS Específico de la página de contacto -->
    <style>
        /* Estilos para la sección de contacto */
        #contacto {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        #contacto h2 {
            color: #333;
            margin-bottom: 20px;
        }
        #contacto p {
            margin-bottom: 40px;
        }
        /* Estilos para el formulario */
        .form-contacto {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .campo input[type="text"],
        .campo input[type="email"],
        .campo textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
            margin: 8px;
        }
        .campo textarea {
            resize: vertical; /* Permite al usuario ajustar la altura del textarea */
        }
        .accion{
            margin-top: 10px;
        }
        /* Botón de envío */
        .accion button {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .accion button:hover {
            background-color: #004494;
        }
    </style>
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script>
        (function(){
            emailjs.init("vEqxMvQsgU5kCJJOH"); // Reemplaza "tu_user_id" con tu User ID de EmailJS
        })();
    </script>

</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php';?>
    <div>
        <section id="contacto">
            <h2>Contacta con nosotros</h2>
            <p>Si tienes cualquier pregunta, no dudes en enviarnos un mensaje.</p>
            <form id="formularioContacto" class="form-contacto" action="#" method="post">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <!-- Imprime el nombre del usuario guardado en la sesión, si existe -->
                    <input type="text" id="nombre" name="nombre" value="<?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : ''; ?>" required>
                </div>
                <div class="campo">
                    <label for="email">Correo electrónico:</label>
                    <!-- Imprime el correo del usuario guardado en la sesión, si existe -->
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : ''; ?>" required>
                </div>
                <div class="campo">
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" required>
                </div>
                <div class="campo">
                    <label for="mensaje_contacto">Mensaje:</label>
                    <textarea id="mensaje_contacto" name="mensaje_contacto" rows="4" required></textarea>
                </div>
                <div class="campo accion">
                    <button type="submit">Enviar Mensaje</button>
                </div>
            </form>
        </section>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
    <script>
        function enviarFormularioContacto() {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
            var nombre = document.getElementById('nombre').value;
            var email = document.getElementById('email').value;
            var asunto = document.getElementById('asunto').value;
            var mensaje_contacto = document.getElementById('mensaje_contacto').value;

            // Asegurarte de que los campos no estén vacíos (podrías añadir validaciones adicionales)
            if (!nombre || !email || !asunto || !mensaje_contacto) {
                alert('Por favor, completa todos los campos.');
                return;
            }

            // Preparar los datos a enviar
            var datosParaEnviar = {
                nombre: nombre,
                email: email,
                asunto: asunto,
                mensaje: mensaje_contacto
            };

            emailjs.send('service_6bfkabv', 'template_g7dmrfz', datosParaEnviar)
                .then(function(response) {
                    console.log('SUCCESS!', response.status, response.text);
                    alert('Tu mensaje ha sido enviado con éxito.');
                }, function(error) {
                    console.log('FAILED...', error);
                    alert('Error al enviar el mensaje. Por favor, intenta de nuevo.');
                });
        }
        // Añadir listener al formulario
        window.onload = function() {
            document.getElementById('formularioContacto').addEventListener('submit', enviarFormularioContacto);
        }
    </script>
</body>
</html>
