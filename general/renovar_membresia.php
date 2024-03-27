<?php
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
$correoUsuario = $_SESSION['correo'] ?? '';
$sqlFechaActual = "SELECT FECHA_VENC FROM USUARIOS WHERE CORREO = '$correoUsuario'";
$resultado = mysqli_query($conn, $sqlFechaActual);
if ($fila = mysqli_fetch_assoc($resultado)) {
    $fecha_vencimiento_actual = new DateTime($fila['FECHA_VENC']);
    $fecha_hoy = new DateTime();
    $intervalo = $fecha_hoy->diff($fecha_vencimiento_actual);
    if ($intervalo->days > 7 && $fecha_vencimiento_actual > $fecha_hoy) {
        echo json_encode(['exito' => false, 'mensaje' => 'No es posible renovar la suscripción más de 7 días antes de su vencimiento.']);
        exit;
    }
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'No se pudo obtener la fecha de vencimiento actual.']);
    exit;
}
$suscripcion = $_POST['tipoCuotaRenovacion'] ?? '';
switch ($suscripcion) {
    case 'semanal':
        $fecha_vencimiento = $fecha_vencimiento_actual->modify('+1 week')->format('Y-m-d');
        break;
    case 'mensual':
        $fecha_vencimiento = $fecha_vencimiento_actual->modify('+1 month')->format('Y-m-d');
        break;
    case 'semestral':
        $fecha_vencimiento = $fecha_vencimiento_actual->modify('+6 months')->format('Y-m-d');
        break;
    default:
        echo json_encode(['exito' => false, 'mensaje' => 'Tipo de cuota de renovación no válido.']);
        exit;
}
$sql = "UPDATE USUARIOS SET FECHA_VENC = '$fecha_vencimiento' WHERE CORREO = '$correoUsuario'";
if (mysqli_query($conn, $sql)) {
    $respuesta = ['exito' => true, 'mensaje' => 'Renovación completada con éxito.'];
} else {
    $respuesta = ['exito' => false, 'mensaje' => 'Error al renovar la suscripción.'];
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($respuesta);
?>
