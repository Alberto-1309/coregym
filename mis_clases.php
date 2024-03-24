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
$correoUsuario = $_SESSION['correo'] ?? '';
// Prevenir inyecciones SQL
$correoUsuario = mysqli_real_escape_string($conn, $correoUsuario);
// Primero, obtenemos el USUARIOID basado en el correo
$sqlUsuario = "SELECT USUARIOID FROM usuarios WHERE CORREO = '$correoUsuario'";
$resultadoUsuario = mysqli_query($conn, $sqlUsuario);
$rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
$usuarioId = $rowUsuario['USUARIOID'] ?? 0;
// Ahora, buscamos las clases y las sesiones a las que asiste el usuario
$sqlClases = "SELECT c.NOMBRECLASE, s.FECHA_SESION, s.HORA_SESION, c.DESCRIPCION
              FROM clases c
              JOIN sesiones s ON c.CLASEID = s.CLASEID
              JOIN atiende a ON s.SESIONID = a.SESIONID
              WHERE a.USUARIOID = $usuarioId";
$resultadoClases = mysqli_query($conn, $sqlClases);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coregym</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php';?>
    <div class="cuerpo">
        <?php if (mysqli_num_rows($resultadoClases) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($resultadoClases)): ?>
                <div class="clase">
                    <h2><?= $row['NOMBRECLASE'] ?></h2>
                    <p><?= $row['FECHA_SESION'] ?> <?= $row['HORA_SESION'] ?></p>
                    <button onclick="toggleDetalles(this)">Ver más detalles</button>
                    <div class="detalle">
                        <p><?= $row['DESCRIPCION'] ?></p>
                        <button onclick="toggleDetalles(this)">Ver menos detalles</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No has registrado clases aún.</p>
        <?php endif; ?>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
    <script>
        function toggleDetalles(button) {
            var detalleDiv = button.parentNode.querySelector('.detalle');
            if (detalleDiv.style.display === 'none') {
                detalleDiv.style.display = 'block';
                button.textContent = 'Ver menos detalles';
            } else {
                detalleDiv.style.display = 'none';
                button.textContent = 'Ver más detalles';
            }
        }
    </script>
</body>
</html>
