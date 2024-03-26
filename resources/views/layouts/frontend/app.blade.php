<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    <title>{{ $title ?? env('APP_NAME') }}</title>

    <!-- Mobile Specific Metas
================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Construction Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name=author content="Themefisher">
    <meta name=generator content="Themefisher Constra HTML Template v1.0">

    <!-- Favicon
================================================== -->
    <link rel="icon" type="image/png" href="{{ asset('/') }}img/logo.jpg">

    <!-- CSS
================================================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/bootstrap/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/fontawesome/css/all.min.css">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/animate-css/animate.css">
    <!-- slick Carousel -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/slick/slick.css">
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/slick/slick-theme.css">
    <!-- Colorbox -->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/plugins/colorbox/colorbox.css">
    <!-- Template styles-->
    <link rel="stylesheet" href="{{ asset('/frontend_theme') }}/css/style.css">
    @stack('css')
</head>

<body>
    <div class="body-inner">

        @include('layouts.frontend.header')

        @yield('content')

        <footer id="footer" class="footer bg-overlay">


            <div class="copyright">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="copyright-info">
                                <span>Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>, Designed &amp; Developed by <a
                                        href="https://mixdev.id">Mixdev.id</a>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="footer-menu text-center text-md-right">
                                <ul class="list-unstyled">
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="team.html">Our people</a></li>
                                    <li><a href="faq.html">Faq</a></li>
                                    <li><a href="news-left-sidebar.html">Blog</a></li>
                                    <li><a href="pricing.html">Pricing</a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- Row end -->

                    <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
                        <button class="btn btn-primary" title="Back to Top">
                            <i class="fa fa-angle-double-up"></i>
                        </button>
                    </div>

                </div><!-- Container end -->
            </div><!-- Copyright end -->
        </footer><!-- Footer end -->


        <!-- Javascript Files
    ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="{{ asset('/frontend_theme') }}/plugins/jQuery/jquery.min.js"></script>
        <!-- Bootstrap jQuery -->
        <script src="{{ asset('/frontend_theme') }}/plugins/bootstrap/bootstrap.min.js" defer></script>
        <!-- Slick Carousel -->
        <script src="{{ asset('/frontend_theme') }}/plugins/slick/slick.min.js"></script>
        <script src="{{ asset('/frontend_theme') }}/plugins/slick/slick-animation.min.js"></script>
        <!-- Color box -->
        <script src="{{ asset('/frontend_theme') }}/plugins/colorbox/jquery.colorbox.js"></script>
        <!-- shuffle -->
        <script src="{{ asset('/frontend_theme') }}/plugins/shuffle/shuffle.min.js" defer></script>


        <!-- Google Map API Key-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <!-- Google Map Plugin-->
        <script src="{{ asset('/frontend_theme') }}/plugins/google-map/map.js" defer></script>

        <!-- Template custom -->
        <script src="{{ asset('/frontend_theme') }}/js/script.js"></script>
        @stack('js')
    </div><!-- Body inner end -->
</body>

</html>
