<section>
    <header>
        <div class="logo"><img src="./img/logo_coregym.png" width="50px" height="50px"/></div>
        <nav>
            <a href="donde-estamos.php">Donde estamos</a>
            <a href="actividades.php">Actividades</a>
            <a href="cuotas.php">Cuotas</a>
            <a href="sobre-nosotros.php">+Sobre nosotros</a>
            <a href="contacto.php">Contacto</a>
            <?php if(isset($_SESSION['usuario'])): ?>
                <a href="mis_clases.php">Mis clases</a>
                <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                    <form action="logout.php" method="post" style="display: inline;">
                        <button type="submit" id="btnCerrarSesion" style="cursor: pointer;">Cerrar Sesión</button>
                    </form>
            <?php else: ?>
                <button id="btnRegistrarse">INSCRÍBETE</button>
                <button id="btnInicio">MI CUENTA</button>
            <?php endif; ?>
        </nav>
    </header>
</section>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const btnCerrarSesion = document.getElementById('btnCerrarSesion');

        if (btnCerrarSesion) {
            btnCerrarSesion.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Realiza una solicitud AJAX para cerrar sesión
                fetch('general/logout.php', {
                    method: 'POST',
                    // Agrega cualquier encabezado o cuerpo necesario para tu solicitud
                })
                .then(response => {
                    if (response.ok) {
                        // Recarga la página después de cerrar sesión
                        window.location.reload();
                    } else {
                        alert('La sesión no se pudo cerrar correctamente.');
                    }
                })
                .catch(error => {
                    console.error('Error al cerrar sesión:', error);
                });
            });
        }
    });
</script>