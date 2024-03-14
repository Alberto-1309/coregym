<?php
$servername = "localhost";
$username = "coregym";
$password = ""; // Asumiendo que no hay contraseña, como en tu ejemplo
$dbname = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Asumiendo que recibimos el correo como un objeto JSON en el cuerpo de la petición
$datos = json_decode(file_get_contents('php://input'), true);
$correo = $datos['correo'];

// Preparar la consulta SQL para verificar si el correo ya existe
$stmt = $conn->prepare("SELECT COUNT(*) AS existe FROM USUARIOS WHERE CORREO = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Cerrar el statement y la conexión
$stmt->close();
$conn->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
if ($row['existe'] > 0) {
    // Si existe, devolvemos true
    echo json_encode(['existe' => true]);
} else {
    // Si no existe, devolvemos false
    echo json_encode(['existe' => false]);
}
?>
