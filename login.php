<?php
session_start();

$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Preparar la consulta para obtener también el NOMBRE del usuario
$stmt = $conn->prepare("SELECT NOMBRE, CONTRASENA FROM USUARIOS WHERE CORREO = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($contrasena == $row['CONTRASENA']) {
        // Establecer el nombre del usuario en $_SESSION['usuario']
        $_SESSION['usuario'] = $row['NOMBRE'];

        // Ajuste para verificar si el usuario marcó la casilla 'sesion_iniciada'
        if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
            $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
            setcookie('usuarioLogueado', $row['NOMBRE'], $expiracion, "/");
        }
        // Redirige a una página específica o muestra un mensaje de éxito
        // Por ejemplo: header('Location: paginaPrincipal.php'); exit();
    } else {
        echo "Contraseña incorrecta";
        // Considera redirigir al usuario a una página de error o volver al formulario de login
    }
} else {
    echo "No se encontró el usuario";
    // Considera redirigir al usuario a una página de error o volver al formulario de login
}

$stmt->close();
$conn->close();
?>
