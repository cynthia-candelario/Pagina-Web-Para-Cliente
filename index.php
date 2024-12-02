<?php
// Inicializar las variables
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar el nombre
    if (empty($_POST["name"])) {
        $nameErr = "El nombre es obligatorio.";
    } else {
        $name = sanitize_input($_POST["name"]);
    }

    // Validar el correo electrónico
    if (empty($_POST["email"])) {
        $emailErr = "El correo electrónico es obligatorio.";
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de correo electrónico inválido.";
        }
    }

    // Validar el mensaje
    if (empty($_POST["message"])) {
        $messageErr = "El mensaje no puede estar vacío.";
    } else {
        $message = sanitize_input($_POST["message"]);
    }

    // Si no hay errores, enviar el mensaje
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        // Preparar el correo electrónico
        $to = "info@tupagina.com";  // Cambia esto por tu correo electrónico
        $subject = "Nuevo mensaje de $name";
        $body = "Nombre: $name\nCorreo electrónico: $email\nMensaje: $message";
        $headers = "From: $email";

        // Enviar el correo electrónico
        if (mail($to, $subject, $body, $headers)) {
            $successMessage = "¡Gracias por contactarnos! Nos pondremos en contacto contigo pronto.";
        } else {
            $errorMessage = "Hubo un error al enviar tu mensaje. Intenta nuevamente.";
        }
    }
}

// Función para limpiar y sanitizar las entradas
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Studio Design - Diseño Web Creativo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Barra de navegación -->
    <header>
        <nav>
            <div class="logo">
                <h1>Studio Design</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Inicio</a></li>
                <li><a href="#about">Acerca de</a></li>
                <li><a href="#services">Servicios</a></li>
                <li><a href="#contact">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sección Hero -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h2>Transformamos tu Visión en Realidad</h2>
            <p>Diseñamos soluciones digitales únicas para impulsar tu negocio.</p>
            <a href="#contact" class="cta-btn">Solicita una Consulta</a>
        </div>
    </section>

    <!-- Sección Acerca de -->
    <section id="about" class="about">
        <div class="container">
            <h2>¿Quiénes Somos?</h2>
            <p>En Studio Design, nos especializamos en crear experiencias digitales de alta calidad. Nuestro equipo de diseñadores y desarrolladores trabaja incansablemente para ofrecerte soluciones personalizadas que resuelvan tus necesidades de manera eficiente y creativa.</p>
        </div>
    </section>

    <!-- Sección de Servicios -->
    <section id="services" class="services">
        <div class="container">
            <h2>Nuestros Servicios</h2>
            <div class="service-item">
                <h3>Diseño Web Profesional</h3>
                <p>Creación de sitios web modernos, rápidos y optimizados para cualquier dispositivo. ¡Haz que tu negocio se vea increíble!</p>
            </div>
            <div class="service-item">
                <h3>Desarrollo a Medida</h3>
                <p>Desarrollo de soluciones personalizadas que se adaptan exactamente a las necesidades de tu empresa.</p>
            </div>
            <div class="service-item">
                <h3>Consultoría Digital</h3>
                <p>Te ayudamos a definir tu estrategia digital y mejorar la presencia online de tu negocio.</p>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contáctanos</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="name" placeholder="Tu Nombre" value="<?php echo $name; ?>" required>
                <span class="error"><?php echo $nameErr; ?></span>

                <input type="email" name="email" placeholder="Tu Correo Electrónico" value="<?php echo $email; ?>" required>
                <span class="error"><?php echo $emailErr; ?></span>

                <textarea name="message" placeholder="Tu Mensaje" required><?php echo $message; ?></textarea>
                <span class="error"><?php echo $messageErr; ?></span>

                <button type="submit">Enviar Mensaje</button>
            </form>

            <?php
            if (isset($successMessage)) {
                echo "<p class='success'>$successMessage</p>";
            }
            if (isset($errorMessage)) {
                echo "<p class='error'>$errorMessage</p>";
            }
            ?>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 Studio Design. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
