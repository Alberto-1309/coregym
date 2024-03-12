<?php
session_start(); // Inicia la sesión
session_unset(); // Remueve todas las variables de sesión
session_destroy(); // Destruye la sesión

// Verificar si la cookie existe y borrarla
if (isset($_COOKIE['usuarioLogueado'])) {
    unset($_COOKIE['usuarioLogueado']);
    // Establecer el tiempo de expiración en el pasado para eliminarla
    setcookie('usuarioLogueado', '', time() - 3600, "/");
}

exit();
?>
