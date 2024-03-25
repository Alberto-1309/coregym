
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) && !isset($_SESSION['correo'])) {
    header('Location: ./index.php');
    exit();
}
?>
<?php
$servername = "localhost";
$username = "coregym";
$password = "";
$dbname = "pw";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$correoUsuario = $_SESSION['correo'] ?? '';
$correoUsuario = mysqli_real_escape_string($conn, $correoUsuario);
$sqlUsuario = "SELECT USUARIOID FROM usuarios WHERE CORREO = '$correoUsuario'";
$resultadoUsuario = mysqli_query($conn, $sqlUsuario);
$rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
$usuarioId = $rowUsuario['USUARIOID'] ?? 0;
$_SESSION['usuarioId'] = $usuarioId;
$sqlClases = "SELECT c.CLASEID, s.FECHA_SESION, c.DESCRIPCION, a.SESIONID
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
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        /* Estilos para clases */
        .clase {
            background: #fff;
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .clase h2 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .clase p {
            margin: 0;
            color: #666;
        }
        .detalle {
            display: none;
            padding-top: 10px;
        }
        /* Estilos para botones dentro de la sección de clases */
        .clase button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .clase button:hover {
            background-color: #0056b3;
        }
        /* Estilos específicos para los botones de 'Ver más detalles' y 'Ver menos detalles' */
        .clase .toggleDetalles {
            font-size: 0.9rem;
            text-decoration: underline;
            background: none;
            color: #007bff;
            padding: 0;
            border: none;
            cursor: pointer;
        }
        /* Ajustes para mejorar la accesibilidad */
        .clase button:focus {
            outline: 2px solid #0056b3;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <?php include './general/header.php';?>
    <div class="cuerpo">
        <?php if (mysqli_num_rows($resultadoClases) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($resultadoClases)): ?>
                <div class="clase">
                    <h2>SALA: <?= htmlspecialchars($row['CLASEID']) ?></h2>
                    <p>Fecha y hora: <?= date('Y-m-d H:i:s', strtotime($row['FECHA_SESION'])) ?></p>
                    <div class="detalle">
                        <p>Descripción: <?= htmlspecialchars($row['DESCRIPCION']) ?></p>
                    </div>
                    <button onclick="toggleDetalles(this)">Ver más detalles</button>
                    <button class="eliminarAsistencia" data-sesionid="<?= $row['SESIONID'] ?>">Eliminar asistencia</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="clase">
                <p>No has registrado clases aún.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php include './general/footer.php';?>
    <script>
        //Script para ocultar y motrar los detalles
        function toggleDetalles(button) {
            var detalleDiv = button.parentNode.querySelector('.detalle');
            if (detalleDiv.style.display !== 'block') {
                detalleDiv.style.display = 'block';
                button.textContent = 'Ver menos detalles';
            } else {
                detalleDiv.style.display = 'none';
                button.textContent = 'Ver más detalles';
            }
        }
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.detalle').forEach(function(detalle) {
                detalle.style.display = 'none';
            });
        });
        //Script para eliminar asistencia a una clase     
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.eliminarAsistencia').forEach(button => {
                button.addEventListener('click', function() {
                    const sesionId = this.getAttribute('data-sesionid');
                    if(confirm('¿Estás seguro de que quieres eliminar tu asistencia a esta clase?')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "./general/eliminar_asistencia.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                                window.location.reload();
                                alert('Asistencia eliminada con éxito.');
                            }
                        }
                        xhr.send("sesionId=" + sesionId);
                    }
                });
            });
        });
    </script>
</body>
</html>
