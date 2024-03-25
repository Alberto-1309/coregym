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
$sql = "SELECT NOMBRE, CONTRASENA, CORREO FROM USUARIOS WHERE CORREO = '$correo'";
$result = mysqli_query($conn, $sql);
$loginExitoso = false;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($contrasena == $row['CONTRASENA']) {
        $_SESSION['usuario'] = $row['NOMBRE'];
        $_SESSION['correo'] = $row['CORREO'];
        if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
            $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
            setcookie('usuarioLogueado', $row['NOMBRE'], $expiracion, "/");
            setcookie('correoUsuario', $row['CORREO'], $expiracion, "/");
        }
        $loginExitoso = true;
    }
}
mysqli_close($conn);
$respuesta = [
    'exito' => $loginExitoso
];
header('Content-Type: application/json');
echo json_encode($respuesta);
?>
