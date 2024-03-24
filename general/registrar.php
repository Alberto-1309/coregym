<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Verificar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Recoger y procesar datos del formulario
$suscripcion = $_POST['suscripcion'] ?? '';
$fecha_inicio = new DateTime();
switch ($suscripcion) {
    case 'semanal':
        $fecha_vencimiento = $fecha_inicio->modify('+1 week')->format('Y-m-d');
        break;
    case 'mensual':
        $fecha_vencimiento = $fecha_inicio->modify('+1 month')->format('Y-m-d');
        break;
    case 'semestral':
        $fecha_vencimiento = $fecha_inicio->modify('+6 months')->format('Y-m-d');
        break;
    default:
        $fecha_vencimiento = $fecha_inicio->format('Y-m-d');
}
$sexo = $_POST['sexo'] ?? 'otro';
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
$dni = mysqli_real_escape_string($conn, $_POST['dni']);
$fecha_nac = mysqli_real_escape_string($conn, $_POST['fecha_nac']);
$peso = !empty($_POST['peso']) ? mysqli_real_escape_string($conn, $_POST['peso']) : NULL;
$altura = !empty($_POST['altura']) ? mysqli_real_escape_string($conn, $_POST['altura']) : NULL;
$correo = mysqli_real_escape_string($conn, $_POST['correo']);
$contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);
// Construir la consulta SQL para la inserción
$sql = "INSERT INTO USUARIOS (NOMBRE, APELLIDO, DNI, SEXO, FECHA_NAC, FECHA_VENC, PESO, ALTURA, CORREO, CONTRASENA) VALUES ('$nombre', '$apellido', '$dni', '$sexo', '$fecha_nac', '$fecha_vencimiento', '$peso', '$altura', '$correo', '$contrasena')";
// Intentar ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    // Si la inserción fue exitosa, prepara una respuesta de éxito
    $respuesta = ['exito' => true, 'mensaje' => 'Registro completado con éxito'];
} else {
    // Si la inserción falló, prepara una respuesta de error
    $respuesta = ['exito' => false, 'mensaje' => 'Error al registrar los datos.'];
}
// Cerrar la conexión
mysqli_close($conn);
// Gestión de sesión y cookies
session_start();
$_SESSION['usuario'] = $nombre;
$_SESSION['correo'] = $correo;
if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
    $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
    setcookie('usuarioLogueado', $nombre, $expiracion, "/");
    setcookie('correoUsuario', $correo, $expiracion, "/");
}
// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>