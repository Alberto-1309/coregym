<?php
// Iniciar sesión para usar $_SESSION
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redirigir a la página de login si no está logueado
    exit;
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Suponiendo que tienes una función que obtiene los datos del usuario basado en la sesión
function obtenerDatosUsuario($correo) {
    global $conn; // Utilizar la variable de conexión fuera del ámbito local
    $sql = "SELECT * FROM USUARIOS WHERE CORREO = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultado);
}

// Obtener datos del usuario actual
$datos_usuario = obtenerDatosUsuario($_SESSION['correo']);

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Datos</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type=text], input[type=date], input[type=number], input[type=email], input[type=password] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php';?>
    <div class="cuerpo">
        <h1>Editar Mis Datos</h1>
        <form id="formularioDatos">        
            Nombre: <input type="text" name="nombre" value="<?php echo $datos_usuario['NOMBRE']; ?>" required><br>
            Apellido: <input type="text" name="apellido" value="<?php echo $datos_usuario['APELLIDO']; ?>" required><br>
            DNI: <input type="text" name="dni" value="<?php echo $datos_usuario['DNI']; ?>" required><br>
            Sexo: <input type="text" name="sexo" value="<?php echo $datos_usuario['SEXO']; ?>" required><br>
            Fecha de nacimiento: <input type="date" name="fecha_nac" value="<?php echo $datos_usuario['FECHA_NAC']; ?>" required><br>
            Peso (kg): <input type="number" name="peso" value="<?php echo $datos_usuario['PESO']; ?>"><br>
            Altura (cm): <input type="number" name="altura" value="<?php echo $datos_usuario['ALTURA']; ?>"><br>
            Correo electrónico: <input type="email" name="correo" value="<?php echo $datos_usuario['CORREO']; ?>" required><br>
            Para cambiar sus datos, por favor ingrese su contraseña actual:
            <input type="password" name="contrasena_actual" required><br>
            <input type="submit" value="Actualizar Datos">
        </form>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
    <div id="mensaje" style="display:none;"></div>
    <script>
    document.getElementById('formularioDatos').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario
        
        var formData = new FormData(this);
        
        fetch('./general/procesar_datos.php', {
            method: 'POST',
            body: new URLSearchParams(formData).toString(),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            // La función mostrarMensaje se espera que tome un segundo parámetro booleano indicando si es un error
            mostrarMensaje(data.mensaje, !data.exito); // Nota el uso de `!data.exito` para convertir "éxito" a "no es error"
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje("Ocurrió un error al procesar los datos. Inténtalo de nuevo.", true);
        });
    });
    </script>

</body>
</html>
