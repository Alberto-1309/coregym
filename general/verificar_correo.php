<?php
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$datos = json_decode(file_get_contents('php://input'), true);
$correo = $datos['correo'];
$stmt = $conn->prepare("SELECT COUNT(*) AS existe FROM USUARIOS WHERE CORREO = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
header('Content-Type: application/json');
if ($row['existe'] > 0) {
    echo json_encode(['existe' => true]);
} else {
    echo json_encode(['existe' => false]);
}
?>
