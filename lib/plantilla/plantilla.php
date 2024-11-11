<?php


    class Plantilla
    {


        static function header($titulo,$opciones = array())
        {

            $menu = '';
            if (!$opciones['ocultar_menu'])
            {
                $menu = self::menu();
            }

            return "
                    <!DOCTYPE html>
                    <html lang=\"es-ES\" dir=\"ltr\">

                    <head>
                        <meta charset=\"utf-8\">
                        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                        <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
                        <meta name=\"author\" content=\"TemplatesJungle\">
                        <meta name=\"keywords\" content=\"Online Store\">
                        <meta name=\"description\" content=\"Stylish - Shoes Online Store HTML Template\">

                        <!-- ===============================================-->
                        <!--    Document Title-->
                        <!-- ===============================================-->
                        <title>{$titulo}</title>


                        <!-- ===============================================-->
                        <!--    Favicons-->
                        <!-- ===============================================-->
                        <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"assets/img/favicons/apple-touch-icon.png\">
                        <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"assets/img/favicons/favicon-32x32.png\">
                        <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"assets/img/favicons/favicon-16x16.png\">
                        <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"assets/img/favicons/favicon.ico\">
                        <link rel=\"manifest\" href=\"assets/img/favicons/manifest.json\">
                        <meta name=\"msapplication-TileImage\" content=\"assets/img/favicons/mstile-150x150.png\">
                        <meta name=\"theme-color\" content=\"#ffffff\">


                        <!-- ===============================================-->
                        <!--    Stylesheets-->
                        <!-- ===============================================-->
                        <link href=\"assets/css/theme.css\" rel=\"stylesheet\" />
                        <link href=\"css/styles.css\" rel=\"stylesheet\" />
                        <link rel=\"stylesheet\" href=\"css/vendor.css\">
                        <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
                        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
                        <link
                            href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,900;1,900&family=Source+Sans+Pro:wght@400;600;700;900&display=swap\"
                            rel=\"stylesheet\">

                    </head>


                    <body>

                        <!-- ===============================================-->
                        <!--    Main Content-->
                        <!-- ===============================================-->
                        <main class=\"main\" id=\"top\">
                        <header id=\"header\" class=\"site-header text-black\">
                            <div class=\"header-top border-bottom py-2\">
                            <div class=\"container-lg\">
                                <div class=\"row justify-content-evenly\">
                                <div class=\"col\">
                                    <ul class=\"social-links list-unstyled d-flex m-0\">
                                    <li class=\"pe-2\">
                                        <a href=\"#\">
                                        <svg class=\"facebook\" width=\"20\" height=\"20\">
                                            <use xlink:href=\"#facebook\"></use>
                                        </svg>
                                        </a>
                                    </li>
                                    <li class=\"pe-2\">
                                        <a href=\"#\">
                                        <svg class=\"instagram\" width=\"20\" height=\"20\">
                                            <use xlink:href=\"#instagram\"></use>
                                        </svg>
                                        </a>
                                    </li>
                                    <li class=\"pe-2\">
                                        <a href=\"#\">
                                        <svg class=\"youtube\" width=\"20\" height=\"20\">
                                            <use xlink:href=\"#youtube\"></use>
                                        </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=\"#\">
                                        <svg class=\"pinterest\" width=\"20\" height=\"20\">
                                            <use xlink:href=\"#pinterest\"></use>
                                        </svg>
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                                <div class=\"col\">
                                    <ul class=\"d-flex justify-content-end gap-3 list-unstyled m-0\">
                                    <li>
                                        <a href=\"#\">Contact</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Cart</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Login</a>
                                    </li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            </div>
                           
                        </header>
                                    
            " . $menu;

        }


        static function menu()
        {

            return "
                            <nav id=\"header-nav\" class=\"navbar navbar-expand-lg\">
                            <div class=\"container-lg\">
                                <a class=\"navbar-brand\" href=\"index.php\">
                                <img src=\"img/logo.png\" class=\"logo\" alt=\"logo\">
                                </a>
                                <button class=\"navbar-toggler d-flex d-lg-none order-3 border-0 p-1 ms-2\" type=\"button\" data-bs-toggle=\"offcanvas\"
                                data-bs-target=\"#bdNavbar\" aria-controls=\"bdNavbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                                <svg class=\"navbar-icon\">
                                    <use xlink:href=\"#navbar-icon\"></use>
                                </svg>
                                </button>
                                <div class=\"offcanvas offcanvas-end\" tabindex=\"-1\" id=\"bdNavbar\">
                                <div class=\"offcanvas-body\">
                                    <ul id=\"navbar\" class=\"navbar-nav fw-bold justify-content-end align-items-center flex-grow-1\">
                                    <li class=\"nav-item dropdown\">
                                        <a class=\"nav-link me-5 active dropdown-toggle border-0\" href=\"#\" data-bs-toggle=\"dropdown\"
                                        aria-expanded=\"false\">Home</a>
                                        <ul class=\"dropdown-menu fw-bold\">
                                        <li>
                                            <a href=\"index.php\" class=\"dropdown-item\">Home V1</a>
                                        </li>
                                        <li>
                                            <a href=\"index.php\" class=\"dropdown-item\">Home V2 </a>
                                        </li>
                                        </ul>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a class=\"nav-link me-5\" href=\"./orientado_objetos.php\">orientado_objetos</a>
                                    </li>
                                </div>
                                </div>

                                </ul>
                                </div>
                            </div>
                            </nav>
            ";


        }


        static function footer()
        {
            return "
                <footer id=\"footer\" class=\"py-5 border-top\">
                <div class=\"container-lg\">
                <div class=\"row\">
                    <div class=\"col-lg-2 pb-3\">
                    <div class=\"footer-menu\">
                        <h5 class=\"widget-title pb-3\">About us</h5>
                        <div class=\"footer-contact-text\">
                        <span>Calle Dr. Barraquer, 6, 35500 Arrecife, Las Palmas </span>
                        <br>
                        <span> Call us: 928 81 31 14 </span>
                        <span class=\"text-hover fw-bold light-border\"><a href=\"35015531@gobiernodecanarias.org\">35015531@gobiernodecanarias.org</a></span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"col-md-6\">
                    <p>© Copyright CIFP Zonzamas 2024.</p>
                </div>
                </div>
                </div>
            </footer>



                <!-- ===============================================-->
                <!--    JavaScripts-->
                <!-- ===============================================-->
                <script src=\"vendors/@popperjs/popper.min.js\"></script>
                <script src=\"vendors/bootstrap/bootstrap.min.js\"></script>
                <script src=\"vendors/is/is.min.js\"></script>
                <script src=\"https://polyfill.io/v3/polyfill.min.js?features=window.scroll\"></script>
                <script src=\"vendors/fontawesome/all.min.js\"></script>
                <script src=\"assets/js/theme.js\"></script>

                <link href=\"https://fonts.googleapis.com/css2?family=DM+Serif+Display&amp;family=Rubik:wght@300;400;500;600;700;800&amp;display=swap\" rel=\"stylesheet\">
            </body>

            </html>
            
            
            ";
        }

        static function cargarSeccion($seccion)
        {
            $titulo = 'CIFP Zonzamas';
            if (!empty($seccion))
                $titulo .= ' - '.ucfirst($seccion);
            $salida = Plantilla::header($titulo);
            
            switch($seccion)
            {
                case 'usuarios':
                    $usuarios = new UsuariosCRUD();
                    $salida .= $usuarios->main();
                break;
                default:
                    
                    $salida .= '
                          <section class="pt-6 bg-600" id="home">
                            <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end"><img class="pt-7 pt-md-0 w-100" src="assets/img/gallery/hero-header.png" width="470" alt="hero-header" /></div>
                                <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
                                <h4 class="fw-bold font-sans-serif">Become Master</h4>
                                <h2 class="fs-6 fs-xl-7 mb-5">Learn New Skills Online Find Best Courses</h2><a class="btn btn-primary me-2" href="#!" role="button">Get A Quote</a><a class="btn btn-outline-secondary" href="#!" role="button">Read more</a>
                                </div>
                            </div>
                            </div>
                        </section>
                    
                    ';
                    
                break;
            }
            $salida .= Plantilla::footer();
            return $salida;
        }


    }