<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        p {
            margin: 10px 0;
        }
        .team-member {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .team-member img {
            max-width: 100px;
            margin-right: 20px;
            border-radius: 50%;
        }
        .team-member h3 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .team-member p {
            margin: 0;
        }
        ul {
            padding-left: 20px;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Inclusión del header -->
    <?php include './general/header.php';?>
    <div class="cuerpo">
        <section>
            <h1>Conoce CoreGym</h1>
            <p>En CoreGym, creemos en el poder del bienestar físico y mental para transformar vidas. Fundado en 2024, nuestro gimnasio se ha convertido en un santuario para aquellos que buscan superarse cada día. Ubicado en las afueras de la ciudad, ofrecemos un espacio moderno y acogedor donde cada miembro puede trabajar hacia sus metas de salud y fitness con el mejor soporte posible.</p>
        </section>
        <section>
            <h2>Misión y Visión</h2>
            <p><strong>Misión:</strong> Empoderar a nuestra comunidad para alcanzar su máximo potencial físico y mental a través de un enfoque personalizado y de apoyo en fitness y bienestar.</p>
            <p><strong>Visión:</strong> Ser el líder innovador en bienestar y fitness, creando un impacto positivo duradero en la vida de las personas que atendemos.</p>
        </section>
        <section>
            <h2>¿Por Qué Elegirnos?</h2>
            <ul>
                <li>Instalaciones de vanguardia con equipos de última generación.</li>
                <li>Una amplia gama de clases grupales dirigidas por instructores certificados.</li>
                <li>Planes de entrenamiento personalizados y seguimiento de progreso individual.</li>
                <li>Un enfoque holístico hacia el bienestar, incluyendo nutrición y mindfulness.</li>
            </ul>
        </section>
        <section>
            <h2>Nuestro Equipo</h2>
            <p>Detrás de CoreGym está un equipo dedicado de profesionales del fitness, desde entrenadores personales hasta nutricionistas y expertos en bienestar mental. Conoce a algunos de nuestros líderes:</p>
            <div class="team-member">
                <img src="img/jose.png" alt="Jose Lucia, Entrenador Personal">
                <h3>Jose Lucia</h3>
                <p>Jose Lucía es nuestro Experto en Entrenamiento de Fuerza y Mancuernas, especializado en llevar el entrenamiento con pesas a nuevos niveles. Con una dedicación incansable a la mejora continua, Jose implementa técnicas avanzadas de levantamiento y rutinas de alta intensidad que desafían incluso a los atletas más experimentados. Su metodología se basa en la precisión, el control y la superación de barreras personales, asegurando que cada cliente no solo aumente su fuerza muscular, sino que también desarrolle resistencia y disciplina.</p>
            </div>
            <div class="team-member">
                <img src="img/alberto.png" alt="Jesús Alberto Mellado, Entrenador Personal">
                <h3>Jesús Alberto Mellado</h3>
                <p>Como nuestro Especialista en Rehabilitación y Movilidad, Jesús Alberto Mellado combina técnicas de fisioterapia con entrenamiento personalizado para ayudar a clientes en recuperación o aquellos que buscan mejorar su movilidad y funcionalidad. Su enfoque integral en la recuperación muscular y articular ha transformado la vida de muchos, permitiéndoles alcanzar sus metas de fitness sin dolor.</p>
            </div>
            <div class="team-member">
                <img src="img/candi.png" alt="Cándido Alonso, Entrenador Personal">
                <h3>Cándido Alonso</h3>
                <p>Cándido Alonso se destaca como nuestro Maestro de Técnicas de Entrenamiento de Alta Intensidad, especializándose en CrossFit y entrenamientos metabólicos. Su pasión por desafiar los límites del rendimiento humano lo lleva a crear programas de entrenamiento dinámicos que no solo queman calorías sino que también construyen una fortaleza inquebrantable.</p>
            </div>
        </section>
        <section>
            <h2>Nuestra Historia</h2>
            <p>CoreGym fue concebido por un grupo de entusiastas del fitness que soñaban con un espacio donde la calidad del entrenamiento y el bienestar personal fueran la prioridad. Desde nuestra apertura en 2024, hemos crecido hasta convertirnos en una comunidad de miles de miembros que comparten un objetivo común: vivir una vida más saludable y activa.</p>
        </section>
    </div>
    <!-- Inclusión del footer -->
    <?php include './general/footer.php';?>
</body>
</html>
