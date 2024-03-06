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

// Obteniendo y procesando la suscripción para calcular la fecha de vencimiento
$suscripcion = $_POST['suscripcion'] ?? '';
$fecha_inicio = new DateTime(); // Fecha actual

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
        // Considera manejar este caso de manera adecuada
        $fecha_vencimiento = $fecha_inicio->format('Y-m-d');
}

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO USUARIOS (NOMBRE, APELLIDO, DNI, FECHA_NAC, FECHA_VENC, PESO, ALTURA, CORREO, CONTRASENA) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $nombre, $apellido, $dni, $fecha_nac, $fecha_vencimiento, $peso, $altura, $correo, $contrasenaEncriptada);

// Establecer parámetros y ejecutar
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$fecha_nac = $_POST['fecha_nac']; // Asegúrate de que este campo se envía correctamente desde el formulario
// Nota: ya no necesitas obtener fecha_venc directamente de $_POST
$peso = !empty($_POST['peso']) ? $_POST['peso'] : NULL; // Peso es opcional
$altura = !empty($_POST['altura']) ? $_POST['altura'] : NULL; // Altura es opcional
$correo = $_POST['correo'];
$contrasena = $_POST['contraseña']; // Asegúrate de que el nombre del campo coincide con el del formulario
$contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar contraseña
$stmt->execute();

echo "Registro completado exitosamente";

$stmt->close();
$conn->close();
?>
