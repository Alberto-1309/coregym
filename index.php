<?php
session_start();

if (isset($_COOKIE['usuarioLogueado'])) {
    // Establecer variables de sesión u otro mecanismo para mantener al usuario logueado
    $_SESSION['usuario'] = $_COOKIE['usuarioLogueado'];
}
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

    <!-- CSS FORMULARIOS -->
    <link rel="stylesheet" href="css/formularios.css">

</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php'; ?>


    <!-- Inclusión del footer -->
    <?php include './general/footer.php'; ?>


</body>
</html>
