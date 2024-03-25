<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sesionId'])) {
    session_start();
    if (!isset($_SESSION['usuario']) && !isset($_SESSION['correo']) && !isset($_SESSION['usuarioId'])) {
        echo 'No autorizado';
        exit();
    }
    $sesionId = filter_input(INPUT_POST, 'sesionId', FILTER_SANITIZE_NUMBER_INT);
    $conn = mysqli_connect("localhost", "coregym", "", "pw");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $usuarioId = $_SESSION['usuarioId'];
    $sqlEliminar = "DELETE FROM atiende WHERE SESIONID = ? AND USUARIOID = ?";
    $stmt = mysqli_prepare($conn, $sqlEliminar);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $sesionId, $usuarioId);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "Asistencia eliminada con éxito";
        } else {
            echo "Error al eliminar asistencia";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta";
    }
    mysqli_close($conn);
} else {
    echo "Solicitud no válida";
}
?>
