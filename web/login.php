<?php
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Preparar la consulta
$stmt = $conn->prepare("SELECT CONTRASENA FROM USUARIOS WHERE CORREO = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['CONTRASENA'])) {
        echo "Login exitoso";
        // Aquí podrías redirigir al usuario a otra página o establecer variables de sesión, etc.
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "No se encontró el usuario";
}

$stmt->close();
$conn->close();
?>
