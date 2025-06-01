<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../estilos/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Header -->
  <header class="sticky-top bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
    <a href="../index.php">
      <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo">
    </a>
    <nav class="w-100 ps-4">
      <ul class="nav d-flex justify-content-end">
        <li class="nav-item"><a class="nav-link btn py-3" href="?controller=UsuarioController&action=altaForm">Regístrate ya</a></li>
        <li class="nav-item"><a class="nav-link btn py-3" href="?controller=UsuarioController&action=loginForm">Inicia Sesión</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="start-section d-flex align-items-center">
    <h1 class="hero-title">Conectando pasiones sobre ruedas</h1>
  </section>

  <!-- Sobre nosotros -->
  <section class="hero-section">
    <h2 class="section-title">Sobre nosotros</h2>
    <article class="container d-flex align-items-center gap-4 py-5">
      <p class="about-text">Somos una página destinada a los eventos del motor para que este mundo se expanda y abra un abanico de posibilidades para todos nuestros fanáticos del sector.</p>
      <img src="../img/Kdd-de-coches.jpg" alt="quedada de coches" class="about-img">
    </article>
    <article class="container d-flex align-items-center gap-4 py-5">
      <img src="../img/cochesclasicos.jpg" alt="expo coches clasicos" class="about-img">
      <p class="about-text">Si quieres formar parte de este proyecto, no dudes en echar un ojo a todos nuestros eventos. Gracias por visitarnos.</p>
    </article>
  </section>

  <!-- Footer -->
  <footer class="pt-5 pb-4 px-4 d-flex justify-content-around align-items-center flex-wrap footer">

    <p class="footer-text">Motorgal</p>
    <p><a href="#" class="footer-link">Aviso Legal</a></p>
    <p><a href="#" class="footer-link">Política de Privacidad</a></p>
    <p><a href="#" class="footer-link">Cookies</a></p>
    <p class="footer-text">Adrián García, 2025</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>