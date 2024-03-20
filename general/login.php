<?php
session_start();

$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$correo = $_POST['correo'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$correo = mysqli_real_escape_string($conn, $correo);

$sql = "SELECT NOMBRE, CONTRASENA FROM USUARIOS WHERE CORREO = '$correo'";

$result = mysqli_query($conn, $sql);

$loginExitoso = false; // Define la variable aquí

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($contrasena == $row['CONTRASENA']) {
        $_SESSION['usuario'] = $row['NOMBRE'];
        if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
            $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
            setcookie('usuarioLogueado', $row['NOMBRE'], $expiracion, "/");
        }
        $loginExitoso = true; // Actualiza el estado del login
    }
}

mysqli_close($conn);

// Preparar y enviar la respuesta en formato JSON
$respuesta = [
    'exito' => $loginExitoso
];

header('Content-Type: application/json');
echo json_encode($respuesta);
?>
