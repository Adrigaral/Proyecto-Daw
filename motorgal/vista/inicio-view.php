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
  <header class="sticky-top bg-white border-bottom">
    <nav class="navbar navbar-light px-3 py-2">
      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center me-3" href="index.php">
        <img src="../img/motorgal.png" alt="Logo de Motorgal" id="logo" height="40">
      </a>

      <!-- Menú de navegación -->
      <div class="d-flex flex-column flex-sm-row gap-2 ms-auto" id="mainNavbar">
        <a class="btn btn-sm btn-outline-danger text-white px-3 py-2" href="?controller=UsuarioController&action=altaForm">
          Regístrate ya
        </a>
        <a class="btn btn-sm btn-outline-danger text-white px-3 py-2" href="?controller=UsuarioController&action=loginForm">
          Inicia Sesión
        </a>
      </div>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="start-section d-flex align-items-center">
    <h1 class="hero-title">Conectando pasiones sobre ruedas</h1>
  </section>

  <!-- Sobre nosotros -->
  <section class="hero-section">
    <h2 class="section-title text-center mb-4">Sobre nosotros</h2>

    <article class="container d-flex align-items-center justify-content-center gap-3">
      <p class="about-text flex-fill">
        Somos una página destinada a los eventos del motor para que este mundo se expanda y abra un abanico de posibilidades para todos nuestros fanáticos del sector.
      </p>
      <img src="../img/Kdd-de-coches.jpg" alt="quedada de coches" class="about-img">
    </article>

    <article class="container d-flex align-items-center justify-content-center gap-3 py-5 flex-row-reverse">
      <p class="about-text flex-fill">
        Si quieres formar parte de este proyecto, no dudes en echar un ojo a todos nuestros eventos. Gracias por visitarnos.
      </p>
      <img src="../img/cochesclasicos.jpg" alt="expo coches clasicos" class="about-img">
    </article>
  </section>

  <?php include_once("footer.html"); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>