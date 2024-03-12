<?php
session_start();

$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";

// Conectar a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Escapar las variables para seguridad
$correo = mysqli_real_escape_string($conn, $correo);

// Construir la consulta SQL para obtener el NOMBRE y CONTRASENA del usuario
$sql = "SELECT NOMBRE, CONTRASENA FROM USUARIOS WHERE CORREO = '$correo'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($contrasena == $row['CONTRASENA']) {
        // Establecer el nombre del usuario en $_SESSION['usuario']
        $_SESSION['usuario'] = $row['NOMBRE'];

        // Ajuste para verificar si el usuario marcó la casilla 'sesion_iniciada'
        if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
            $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
            setcookie('usuarioLogueado', $row['NOMBRE'], $expiracion, "/");
        }
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>
