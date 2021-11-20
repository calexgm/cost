<!DOCTYPE html>
<html class="no-js" lang="es">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>COSTS</title>
    <meta name="description" content="Invetario, Costos, Reportes, Graficas">
    <meta name="author" content="CODER SOLUTIONS">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- script
    ================================================== -->
    <script src="{{ asset('js/modernizr.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{ asset('images/icono.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/icono.png') }}" type="image/x-icon">

</head>

<body id="top">

    <!-- header
    ================================================== -->
    <header class="s-header">

        <div class="header-logo">
            <a class="site-logo" href="{{ route('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Homepage">
            </a>
        </div>

        <nav class="header-nav">

            <a href="#0" class="header-nav__close" title="Cerrar"><span>Cerrar</span></a>

            <div class="header-nav__content">
                <h3>Menu</h3>

                <ul class="header-nav__list">
                    <li class="current"><a class="smoothscroll" href="#home" title="Inicio">Inicio</a></li>
                    <li><a class="smoothscroll" href="#about" title="Sobre nosotros">Sobre nosotros</a></li>
                    <li><a class="smoothscroll" href="#services" title="Servicios">Servicios</a></li>
                    <li><a class="smoothscroll" href="#clients" title="Clientes">Clientes</a></li>
                    <li><a class="smoothscroll" href="#contact" title="Contáctanos">Contáctanos</a></li>
                    <li><a href="{{ route('home') }}" title="Iniciar sesión">Iniciar sesión</a></li>
                </ul>

                <ul class="header-nav__social">
                    <li>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-youtube"></i></a>
                    </li>
                </ul>

            </div> <!-- end header-nav__content -->

        </nav> <!-- end header-nav -->

        <a class="header-menu-toggle" href="#0">
            <span class="header-menu-text">Menu</span>
            <span class="header-menu-icon"></span>
        </a>

    </header> <!-- end s-header -->


    <!-- home
    ================================================== -->
    <section id="home" class="s-home target-section" data-parallax="scroll" data-image-src="{{ asset('images/hero-bg.jpg') }}" data-natural-width=3000 data-natural-height=2000 data-position-y=center>

        <div class="overlay"></div>
        <div class="shadow-overlay"></div>

        <div class="home-content">

            <div class="row home-content__main">

                <h3>Te damos la bienvenida a COSTS</h3>

                <h1>
                   Una solución de software <br>
		   que facilita su trabajo. 
                </h1>

                <div class="home-content__buttons">
                    <a href="#contact" class="smoothscroll btn btn--stroke">
                        Adquirir servicio
                    </a>
                    <a href="#about" class="smoothscroll btn btn--stroke">
                        Sobre nosotros
                    </a>
                </div>

            </div>

            <div class="home-content__scroll">
                <a href="#about" class="scroll-link smoothscroll">
                    <span>Ir hacia abajo</span>
                </a>
            </div>

            <div class="home-content__line"></div>

        </div> <!-- end home-content -->


        <ul class="home-social">
            <li>
                <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i><span>Facebook</span></a>
            </li>
            <li>
                <a href="#0"><i class="fa fa-twitter" aria-hidden="true"></i><span>Twiiter</span></a>
            </li>
            <li>
                <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i><span>Instagram</span></a>
            </li>
            <li>
                <a href="#0"><i class="fa fa-youtube" aria-hidden="true"></i><span>Youtube</span></a>
            </li>
        </ul>
        <!-- end home-social -->

    </section> <!-- end s-home -->


    <!-- about
    ================================================== -->
    <section id='about' class="s-about">

        <div class="row section-header has-bottom-sep" data-aos="fade-up">
            <div class="col-full">
                <h3 class="subhead subhead--dark">HOLA A TODOS</h3>
                <h1 class="display-1 display-1--light">Nosotros Somos Costs</h1>
            </div>
        </div> <!-- end section-header -->

        <div class="row about-desc" data-aos="fade-up">
            <div class="col-full">
                <p>
                    Costs es una página de fácil acceso que te permite controlar y manejar tus cuentas/contabilidades mes a mes, quincenal, semanal o para un mejor control día a día; permitiéndonos una discreción y absoluta reserva de tu información
                </p>
            </div>
        </div> <!-- end about-desc -->

        <div class="row about-stats stats block-1-4 block-m-1-2 block-mob-full" data-aos="fade-up">

            <div class="col-block stats__col ">
                <div class="stats__count">90</div>
                <h5>Reconocimientos recibidos</h5>
            </div>
            <div class="col-block stats__col">
                <div class="stats__count">10</div>
                <h5>Servicios</h5>
            </div>
            <div class="col-block stats__col">
                <div class="stats__count">20</div>
                <h5>Clientes</h5>
            </div>
            <div class="col-block stats__col">
                <div class="stats__count">25</div>
                <h5>Registros</h5>
            </div>

        </div> <!-- end about-stats -->

        <div class="about__line"></div>

    </section> <!-- end s-about -->


    <!-- services
    ================================================== -->
    <section id='services' class="s-services">

        <div class="row section-header has-bottom-sep" data-aos="fade-up">
            <div class="col-full">
                <h3 class="subhead">Que hacemos</h3>
                <h1 class="display-2">Tenemos todo lo que necesita para lanzar o hacer crecer su negocio</h1>
            </div>
        </div> <!-- end section-header -->

        <div class="row services-list block-1-2 block-tab-full">

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon">
                    <i class="icon-paint-brush"></i>
                </div>
                <div class="service-text">
                    <h3 class="h2">Módulo Ventas</h3>
                    <p>Te permite realizar las ventas de cada uno de los productos, facilitando el proceso de un inventario que automáticamente la aplicación va desarrollando internamente; siendo más fácil para el usuario saber sus cuentas y que productos sostiene.
                    </p>
                </div>
            </div>

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon">
                    <i class="icon-group"></i>
                </div>
                <div class="service-text">
                    <h3 class="h2">Módulo Inventario</h3>
                    <p>Te permite anexar tus productos llevando consigo la cantidad montada por el usuario, y manejando un reporte de los desfaltos; sabiendo discernir entre que productos hay existentes o faltantes.
                    </p>
                </div>
            </div>

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon">
                    <i class="icon-megaphone"></i>
                </div>
                <div class="service-text">
                    <h3 class="h2">Módulo Reportes</h3>
                    <p>La aplicación (costs) quiere facilitarte el trabajo ahorrando te en tiempo y dinero el proceso de llevar una contabilidad, por eso la aplicación te permite sostener un reporte de tus cuentas siendo así mucho más fácil para el usuario mirar sus gastos y ganancias deseadas por el; teniendo también la opción de llevar sus cuentas al gusto que lo desee.
                    </p>
                </div>
            </div>

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon">
                    <i class="icon-earth"></i>
                </div>
                <div class="service-text">
                    <h3 class="h2">Módulo Adminstrativo</h3>
                    <p>La persona a cargo contara con el privilegio de visualizar el proceso de su personal, consigo pudiendo ser solo él encargado de hacer los cambios en la base de datos de la aplicación (costs).
                    </p>
                </div>
            </div>

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon">
                    <i class="icon-cube"></i>
                </div>
                <div class="service-text">
                    <h3 class="h2">Módulo Offline</h3>
                    <p>Una de las mejores cualidades de la página (costs) es que te permite acceder y trabajar sin una red wifi mejor dicho sin internet, dándole al usuario la tranquilidad y satisfacción de conservar su información contable.
                    </p>
                </div>
            </div>

            <div class="col-block service-item" data-aos="fade-up">
                <div class="service-icon"><i class="icon-lego-block"></i></div>
                <div class="service-text">
                    <h3 class="h2">Módulo Proveedores</h3>
                    <p>¡PRÓXIMAMENTE!
                    </p>
                </div>
            </div>

        </div> <!-- end services-list -->

    </section> <!-- end s-services -->

    <!-- clients
    ================================================== -->
    <section id="clients" class="s-clients">

        <div class="row section-header" data-aos="fade-up">
            <div class="col-full">
                <h3 class="subhead">Nuestros clientes</h3>
                <h1 class="display-2">Costs ha tenido el honor de asociarse con estos clientes</h1>
            </div>
        </div> <!-- end section-header -->

        <div class="row clients-outer" data-aos="fade-up">
            <div class="col-full">
                <div class="clients">

                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/apple.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/atom.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/blackberry.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/dropbox.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/envato.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/firefox.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/joomla.png') }}" /></a>
                    <a href="#0" title="" class="clients__slide"><img src="{{ asset('images/clients/magento.png') }}" /></a>

                </div> <!-- end clients -->
            </div> <!-- end col-full -->
        </div> <!-- end clients-outer -->

        <div class="row clients-testimonials" data-aos="fade-up">
            <div class="col-full">
                <div class="testimonials">

                    <div class="testimonials__slide">

                        <p>Qui ipsam temporibus quisquam vel. Maiores eos cumque distinctio nam accusantium ipsum.
                            Laudantium quia consequatur molestias delectus culpa facere hic dolores aperiam. Accusantium quos qui praesentium corpori.
                        </p>

                        <img src="{{ asset('images/avatars/user-01.jpg') }}" alt="Author image" class="testimonials__avatar">
                        <div class="testimonials__info">
                            <span class="testimonials__name">Santiago Henao</span>
                            <span class="testimonials__pos">CEO</span>
                        </div>

                    </div>

                    <div class="testimonials__slide">

                        <p>Excepturi nam cupiditate culpa doloremque deleniti repellat. Veniam quos repellat voluptas animi adipisci.
                            Nisi eaque consequatur. Quasi voluptas eius distinctio. Atque eos maxime. Qui ipsam temporibus quisquam vel.</p>

                        <img src="{{ asset('images/avatars/user-05.jpg') }}" alt="Author image" class="testimonials__avatar">
                        <div class="testimonials__info">
                            <span class="testimonials__name">Yeisson Estrada</span>
                            <span class="testimonials__pos">CEO</span>
                        </div>

                    </div>

                    <div class="testimonials__slide">

                        <p>Repellat dignissimos libero. Qui sed at corrupti expedita voluptas odit. Nihil ea quia nesciunt. Ducimus aut sed ipsam.
                            Autem eaque officia cum exercitationem sunt voluptatum accusamus. Quasi voluptas eius distinctio.</p>

                        <img src="{{ asset('images/avatars/user-02.jpg') }}" alt="Author image" class="testimonials__avatar">
                        <div class="testimonials__info">
                            <span class="testimonials__name">Nataly Estrada</span>
                            <span class="testimonials__pos">Diseñadora</span>
                        </div>

                    </div>

                </div><!-- end testimonials -->

            </div> <!-- end col-full -->
        </div> <!-- end client-testimonials -->

    </section> <!-- end s-clients -->


    <!-- CONTACTANOS
    ================================================== -->
    <section id="contact" class="s-contact">

        <div class="overlay"></div>
        <div class="contact__line"></div>

        <div class="row section-header" data-aos="fade-up">
            <div class="col-full">
                <h3 class="subhead">Contáctanos</h3>
                <h1 class="display-2 display-2--light">Sí deseas asesoría no dudes en contactarnos</h1>
            </div>
        </div>

        <div class="row contact-content" data-aos="fade-up">

            <div class="contact-primary">

                <h3 class="h6">Envianos un mensaje</h3>

                <form name="contactForm" id="contactForm" method="post" action="" novalidate="novalidate">
                    <fieldset>

                        <div class="form-field">
                            <input name="contactName" type="text" id="contactName" placeholder="Ingrese su nombre" value="" minlength="2" required="" aria-required="true" class="full-width">
                        </div>
                        <div class="form-field">
                            <input name="contactEmail" type="email" id="contactEmail" placeholder="Ingrese su email" value="" required="" aria-required="true" class="full-width">
                        </div>
                        <div class="form-field">
                            <textarea style="resize: none;" name="contactMessage" id="contactMessage" placeholder="Ingrese su mensaje" rows="10" cols="50" required="" aria-required="true" class="full-width"></textarea>
                        </div>
                        <div class="form-field">
                            <button class="full-width btn--primary">Enviar</button>
                            <div class="submit-loader">
                                <div class="text-loader">Enviando...</div>
                                <div class="s-loader">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>

                <!-- contact-warning -->
                <div class="message-warning">
                    Algo salió mal. Inténtalo de nuevo.
                </div>

                <!-- contact-success -->
                <div class="message-success">
                    Tu mensaje fue enviado, ¡gracias!<br>
                </div>

            </div> <!-- end contact-primary -->

            <div class="contact-secondary">
                <div class="contact-info">

                    <h3 class="h6 hide-on-fullwidth">Comunicate</h3>

                    <div class="cinfo">
                        <h5>Dónde encontrarnos</h5>
                        <p>
                            Bello - Antioquia<br>
                            Colombia
                        </p>
                    </div>

                    <div class="cinfo">
                        <h5>Envíenos un email</h5>
                        <p>
                            ventas@costs.com<br>
                            informacion@costs.com
                        </p>
                    </div>

                    <div class="cinfo">
                        <h5>Llamenos</h5>
                        <p>
                            Teléfono: (+57) 316 469 3321<br>
                            Teléfono: (+57) 316 469 3321
                        </p>
                    </div>

                    <ul class="contact-social">
                        <li>
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                        </li>
                    </ul> <!-- end contact-social -->

                </div> <!-- end contact-info -->
            </div> <!-- end contact-secondary -->

        </div> <!-- end contact-content -->

    </section> <!-- end s-contact -->


    <!-- footer
    ================================================== -->
    <footer>

        <div class="row footer-main">

            <div class="col-six tab-full left footer-desc">

                <div class="footer-logo"></div>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Atque, iusto ea qui, assumenda natus cupiditate suscipit at sed dignissimos exercitationem incidunt obcaecati distinctio in repellendus tenetur. Explicabo cumque dolores id?

            </div>

            <div class="col-six tab-full right footer-subscribe">

                <h4>¿Quieres recibir ofertas?</h4>
                <p>Recibiras ofertas, actualizaciones y todas nuestras noticias sobre nuestro sistema de inventarios y reportes.</p>

                <div class="subscribe-form">
                    <form id="mc-form" class="group" novalidate="true">
                        <input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Ingrese su email" required="">
                        <input type="submit" name="subscribe" value="SUSCRIBIRSE">
                        <label for="mc-email" class="subscribe-message"></label>
                    </form>
                </div>

            </div>

        </div> <!-- end footer-main -->

        <div class="row footer-bottom">

            <div class="col-twelve">
                <div class="copyright">
                    <span>© COPYRIGHT COSTS 2021</span>
                </div>

                <div class="go-top">
                    <a class="smoothscroll" title="Back to Top" href="#top"><i class="icon-arrow-up" aria-hidden="true"></i></a>
                </div>
            </div>

        </div> <!-- end footer-bottom -->

    </footer> <!-- end footer -->


    <!-- photoswipe background
    ================================================== -->
    <div aria-hidden="true" class="pswp" role="dialog" tabindex="-1">

        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="Close (Esc)"></button> <button class="pswp__button pswp__button--share" title="Share"></button> <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button> <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div><button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button> <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>

        </div>

    </div> <!-- end photoSwipe background -->


    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader">
            <div class="line-scale-pulse-out">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>


    <!-- Java Script
    ================================================== -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
