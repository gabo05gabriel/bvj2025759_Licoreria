<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquoreria - Página Principal</title>
    <!-- Enlazar el archivo CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Liquoreria</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="ordenes.php">Órdenes</a></li>
                <li><a href="recibos.php">Recibos</a></li>
                <?php
                session_start();
                if (isset($_SESSION['nombre_usuario'])) {
                    echo "<li style='float: right;'><a href='logout.php'>Cerrar Sesión</a></li>";
                    echo "<li style='float: right; margin-right: 10px;'>Hola, " . $_SESSION['nombre_usuario'] . "</li>";
                } else {
                    echo "<li style='float: right;'><a href='login.php'>Iniciar Sesión</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="welcome">
            <h2>Sobre Nosotros</h2>
            <p>Liquoreria es tu tienda de confianza para los mejores licores. Ofrecemos una amplia gama de productos de alta calidad para satisfacer todos los gustos y ocasiones. Explora nuestras promociones y encuentra el licor perfecto para ti.</p>
        </div>

        <div class="carousel">
            <div class="slides">
                <img src="fotos/uno.jpg" alt="Promoción 1">
            </div>
            <div class="slides">
                <img src="fotos/dos.jpg" alt="Promoción 2">
            </div>
            <div class="slides">
                <img src="fotos/tres.jpg" alt="Promoción 3">
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <div class="dot-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
    </script>
</body>
</html>
