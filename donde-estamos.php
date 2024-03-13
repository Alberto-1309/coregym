<?php
// donde-estamos.php
$title = "Dónde Estamos";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
        <!-- CSS GENERAL -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">

        <!-- CSS FORMULARIOS -->
        <link rel="stylesheet" href="css/formularios.css">
        <style>
            .map-container {
                height: 450px;
                width: 100%; /* Hacer que el contenedor del mapa ocupe el ancho completo */
                max-width: 450px; /* Limitar el ancho máximo del mapa para mantener su tamaño */
                margin: 20px auto; /* Centrar el mapa horizontalmente y añadir algo de margen arriba y abajo */
                display: block; /* Asegurarse de que el contenedor se comporte como un bloque */
            }
            iframe {
                display: block; /* Asegura que el iframe se comporte como un bloque */
                width: 100%; /* Hacer que el iframe ocupe el ancho completo de su contenedor */
                border: none; /* Opcional: remover el borde del iframe */
            }
        </style>

</head>
<body>
    <?php include './general/header.php'; ?>
    <div class="cuerpo">
        <h1>Localización</h1>
        <p>Encuéntranos fácilmente en la dirección:</p>
        <ul>
            <li>Escuela Superior de Ingeniería – Universidad de Cádiz</li>
            <li>Campus Universitario de Puerto Real</li>
            <li>Avda. Universidad de Cádiz, nº 10</li>
            <li>CP 11519 – Puerto Real, Cádiz</li>
        </ul>
        <section>
            <h2>¿Por qué nuestra ubicación?</h2>
            <p>Nuestro gimnasio está convenientemente ubicado en las afueras de la ciudad, haciendo que sea fácilmente accesible desde cualquier punto. Estamos cerca de varias líneas de transporte público, incluyendo:</p>
            <ul>
                <li>Estación de renfe Las Aletas.</li>
                <li>Varias líneas de autobús.</li>
            </ul>
            <p>Además, la zona cuenta con amplias opciones de estacionamiento y es conocida por sus parques y áreas verdes, perfectas para continuar tu entrenamiento al aire libre o disfrutar de un merecido descanso después de tu sesión en el gimnasio.</p>
        </section>
        <!-- Aquí incrustarías el mapa de Google Maps -->
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3205.6955232078276!2d-6.204190924324964!3d36.53733937232322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152f79854b8f0de1%3A0x8d075bd9e5895558!2sEscuela%20Superior%20de%20Ingenier%C3%ADa!5e0!3m2!1ses!2ses!4v1710260453329!5m2!1ses!2ses" width="450" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <?php include './general/footer.php'; ?>
</body>
</html>
