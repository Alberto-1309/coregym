<?php
$servername = "localhost";
$username = "coregym";
$password = ""; // Sin contraseña
$dbname = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO USUARIOS (NOMBRE, APELLIDO, DNI, SEXO, FECHA_NAC, FECHA_VENC, PESO, ALTURA, CORREO, CONTRASENA) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $nombre, $apellido, $dni, $sexo, $fecha_nac, $fecha_vencimiento, $peso, $altura, $correo, $contrasenaEncriptada);

// Establecer parámetros y ejecutar
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$fecha_nac = $_POST['fecha_nac'];
$peso = !empty($_POST['peso']) ? $_POST['peso'] : NULL;
$altura = !empty($_POST['altura']) ? $_POST['altura'] : NULL;
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar contraseña
$stmt->execute();

session_start();
$_SESSION['usuario'] = $nombre;

// Ajuste para verificar si el usuario marcó la casilla 'sesion_iniciada'
if (isset($_POST['sesion_iniciada']) && $_POST['sesion_iniciada'] == 'on') {
    $expiracion = time() + (30 * 24 * 60 * 60); // 30 días
    setcookie('usuarioLogueado', $nombre, $expiracion, "/");
}

$stmt->close();
$conn->close();
?>
