<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STOPTIMEFOOD | Gestión Inteligente</title>
    <link rel="stylesheet" href="PRUEBA.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo-container">
                <img src="proyecto.png" alt="Logo" class="logo" />       
            </div>
            <nav class="nav-links">
                <a href="#servicios">Servicios</a>
                <a href="#acerca">Acerca de</a>
                <a href="#contacto">Contacto</a>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="hero-content">
                <h1>STOPTIMEFOOD</h1>
                <p>Reduce el desperdicio y controla la caducidad de tus productos.</p>
            </div>
        </section>

        <section class="section-wrapper" id="servicios">
            <div class="hero-content">
                <h1 class="sub-titulo">Nuestro servicio.</h1>
            </div>
            <p>Contamos con dos módulos especializados según tu perfil: Administrador o Almacenista. Todo integrado en un plan único con acceso total a todas nuestras herramientas.</p>
            <div class="cards-container">
                <div class="card">
                    <h2>Plan integral</h2>
                    <span class="precio-tag">$20.000,00</span>
        
                    <p>Almacenista: ingresa mercancia,registra fechas de caducidad,consulta productos que están por vencer y vista al inventario.</p>
                    <p>Administrador:vista al inventario (puede ver los productos que registró el almacenista),configurar alertas o recordatorios cuando los productos estén por vencer.</p>
                     <button class="btn-login" onclick="window.location.href='inicio de sesion.php'"> Reservar</button>
                
    
        </section>

        <section class="section-wrapper bg-alt" id="acerca">
            <div class="acerca-grid">
                <div class="acerca-info">
                    <h1 class="sub-titulo">Acerca de nuestra marca.</h1>
                    <p>En Stoptimefood, entendemos que el tiempo es el recurso más valioso en una cocina. Por eso, hemos creado una plataforma que permite a los dueños de restaurantes tener un control total sobre su mercancía.</p>
                    <p>A través de nuestra arquitectura de software, logramos que el flujo de insumos sea dinámico y seguro, permitiendo que el equipo de cocina se enfoque en lo que mejor sabe hacer: crear experiencias gastronómicas, mientras nosotros cuidamos el inventario.</p>
                </div>
                <div class="acerca-img-container">
                    <img src="CHEF.jpeg" alt="Chef" class="chef-img">
                </div>
            </div>
        </section>

        <section class="section-wrapper" id="contacto">
            <div class="hero-content">
                <h1 class="sub-titulo">Contáctanos.</h1>
                <p>¿Tienes problemas con tu inventario?</p>
                <p2>Ingresa tus datos y nos pondremos en contacto contigo en breve. Esperamos tener noticias tuyas pronto.</p2>
            </div>

            <form class="contact-form">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" id="nombre"> 
                </div>
                <div class="form-group">
                    <label>Apellido:</label>
                    <input type="text" id="apellido">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" id="email">
                </div>
                <div class="form-group">
                    <label>Ciudad:</label>
                    <input type="text" id="ciudad">
                </div>
                <button type="submit" class="btn-login">ENVIAR</button>
            </form>
        </section>
    </main>

   <script src="PRUEBA.js"></script>
</body>
</html>