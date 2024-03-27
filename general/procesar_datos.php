<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'Usuario no logueado.']);
    exit;
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo json_encode(['exito' => false, 'mensaje' => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$sexo = $_POST['sexo'];
$fecha_nac = $_POST['fecha_nac'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];
$correo = $_POST['correo'];
$contrasena_actual = $_POST['contrasena_actual'];

$sql = "SELECT contrasena FROM USUARIOS WHERE CORREO = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $_SESSION['correo']);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

if ($usuario && $contrasena_actual == $usuario['contrasena']) {
    // Preparar la consulta SQL para actualizar los datos
    $sqlUpdate = "UPDATE USUARIOS SET NOMBRE=?, APELLIDO=?, DNI=?, SEXO=?, FECHA_NAC=?, PESO=?, ALTURA=?, CORREO=? WHERE CORREO=?";
    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, 'sssssdiss', $nombre, $apellido, $dni, $sexo, $fecha_nac, $peso, $altura, $correo, $_SESSION['correo']);
    if (mysqli_stmt_execute($stmtUpdate)) {
        $respuesta = ['exito' => true, 'mensaje' => 'Datos actualizados correctamente.'];
    } else {
        $respuesta = ['exito' => false, 'mensaje' => 'Error al actualizar los datos: ' . mysqli_error($conn)];
    }
} else {
    $respuesta = ['exito' => false, 'mensaje' => 'La contraseña actual no es correcta.'];
}

mysqli_close($conn);
echo json_encode($respuesta);
?>
